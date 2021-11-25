{
  "version": 3,
  "file": "stateEvents.js",
  "sources": [
    "angular-ui-router/src/angular.ts",
    "angular-ui-router/src/legacy/stateEvents.ts"
  ],
  "sourcesContent": [
    "/** @publicapi @module ng1 */ /** */\nimport * as ng_from_import from 'angular';\n/** @hidden */ declare var angular;\n/** @hidden */ const ng_from_global = angular;\n/** @hidden */ export const ng = ng_from_import && ng_from_import.module ? ng_from_import : ng_from_global;\n",
    "/**\n * # Legacy state events\n *\n * Polyfill implementation of the UI-Router 0.2.x state events.\n *\n * The 0.2.x state events are deprecated.  We recommend moving to Transition Hooks instead, as they\n * provide much more flexibility, support async, and provide the context (the Transition, etc) necessary\n * to implement meaningful application behaviors.\n *\n * To enable these state events, include the `stateEvents.js` file in your project, e.g.,\n * ```\n * <script src=\"stateEvents.js\"></script>\n * ```\n * and also make sure you depend on the `ui.router.state.events` angular module, e.g.,\n * ```\n * angular.module(\"myApplication\", ['ui.router', 'ui.router.state.events']\n * ```\n *\n * @publicapi @module ng1_state_events\n */ /** */\nimport { ng as angular } from '../angular';\nimport { IScope, IAngularEvent, IServiceProviderFactory } from 'angular';\nimport {\n  Obj,\n  TargetState,\n  StateService,\n  Transition,\n  TransitionService,\n  UrlRouter,\n  HookResult,\n  UIInjector,\n} from '@uirouter/core';\nimport { StateProvider } from '../stateProvider';\n\n/**\n * An event broadcast on `$rootScope` when the state transition **begins**.\n *\n * ### Deprecation warning: use [[TransitionService.onStart]] instead\n *\n * You can use `event.preventDefault()`\n * to prevent the transition from happening and then the transition promise will be\n * rejected with a `'transition prevented'` value.\n *\n * Additional arguments to the event handler are provided:\n * - `toState`: the Transition Target state\n * - `toParams`: the Transition Target Params\n * - `fromState`: the state the transition is coming from\n * - `fromParams`: the parameters from the state the transition is coming from\n * - `options`: any Transition Options\n * - `$transition$`: the [[Transition]]\n *\n * #### Example:\n * ```js\n * $rootScope.$on('$stateChangeStart', function(event, transition) {\n *   event.preventDefault();\n *   // transitionTo() promise will be rejected with\n *   // a 'transition prevented' error\n * })\n * ```\n *\n * @event $stateChangeStart\n * @deprecated\n */\nexport let $stateChangeStart: IAngularEvent;\n\n/**\n * An event broadcast on `$rootScope` if a transition is **cancelled**.\n *\n * ### Deprecation warning: use [[TransitionService.onStart]] instead\n *\n * Additional arguments to the event handler are provided:\n * - `toState`: the Transition Target state\n * - `toParams`: the Transition Target Params\n * - `fromState`: the state the transition is coming from\n * - `fromParams`: the parameters from the state the transition is coming from\n * - `options`: any Transition Options\n * - `$transition$`: the [[Transition]] that was cancelled\n *\n * @event $stateChangeCancel\n * @deprecated\n */\nexport let $stateChangeCancel: IAngularEvent;\n\n/**\n * An event broadcast on `$rootScope` once the state transition is **complete**.\n *\n * ### Deprecation warning: use [[TransitionService.onStart]] and [[Transition.promise]], or [[Transition.onSuccess]]\n *\n * Additional arguments to the event handler are provided:\n * - `toState`: the Transition Target state\n * - `toParams`: the Transition Target Params\n * - `fromState`: the state the transition is coming from\n * - `fromParams`: the parameters from the state the transition is coming from\n * - `options`: any Transition Options\n * - `$transition$`: the [[Transition]] that just succeeded\n *\n * @event $stateChangeSuccess\n * @deprecated\n */\nexport let $stateChangeSuccess: IAngularEvent;\n\n/**\n * An event broadcast on `$rootScope` when an **error occurs** during transition.\n *\n * ### Deprecation warning: use [[TransitionService.onStart]] and [[Transition.promise]], or [[Transition.onError]]\n *\n * It's important to note that if you\n * have any errors in your resolve functions (javascript errors, non-existent services, etc)\n * they will not throw traditionally. You must listen for this $stateChangeError event to\n * catch **ALL** errors.\n *\n * Additional arguments to the event handler are provided:\n * - `toState`: the Transition Target state\n * - `toParams`: the Transition Target Params\n * - `fromState`: the state the transition is coming from\n * - `fromParams`: the parameters from the state the transition is coming from\n * - `error`: The reason the transition errored.\n * - `options`: any Transition Options\n * - `$transition$`: the [[Transition]] that errored\n *\n * @event $stateChangeError\n * @deprecated\n */\nexport let $stateChangeError: IAngularEvent;\n\n/**\n * An event broadcast on `$rootScope` when a requested state **cannot be found** using the provided state name.\n *\n * ### Deprecation warning: use [[StateService.onInvalid]] instead\n *\n * The event is broadcast allowing any handlers a single chance to deal with the error (usually by\n * lazy-loading the unfound state). A `TargetState` object is passed to the listener handler,\n * you can see its properties in the example. You can use `event.preventDefault()` to abort the\n * transition and the promise returned from `transitionTo()` will be rejected with a\n * `'transition aborted'` error.\n *\n * Additional arguments to the event handler are provided:\n * - `unfoundState` Unfound State information. Contains: `to, toParams, options` properties.\n * - `fromState`: the state the transition is coming from\n * - `fromParams`: the parameters from the state the transition is coming from\n * - `options`: any Transition Options\n *\n * #### Example:\n * ```js\n * // somewhere, assume lazy.state has not been defined\n * $state.go(\"lazy.state\", { a: 1, b: 2 }, { inherit: false });\n *\n * // somewhere else\n * $scope.$on('$stateNotFound', function(event, transition) {\n * function(event, unfoundState, fromState, fromParams){\n *     console.log(unfoundState.to); // \"lazy.state\"\n *     console.log(unfoundState.toParams); // {a:1, b:2}\n *     console.log(unfoundState.options); // {inherit:false} + default options\n * });\n * ```\n *\n * @event $stateNotFound\n * @deprecated\n */\nexport let $stateNotFound: IAngularEvent;\n\n(function() {\n  const { isFunction, isString } = angular;\n\n  function applyPairs(memo: Obj, keyValTuple: any[]) {\n    let key: string, value: any;\n    if (Array.isArray(keyValTuple)) [key, value] = keyValTuple;\n    if (!isString(key)) throw new Error('invalid parameters to applyPairs');\n    memo[key] = value;\n    return memo;\n  }\n\n  function stateChangeStartHandler($transition$: Transition) {\n    if (!$transition$.options().notify || !$transition$.valid() || $transition$.ignored()) return;\n\n    const $injector = $transition$.injector();\n    const $stateEvents = $injector.get('$stateEvents');\n    const $rootScope = $injector.get('$rootScope');\n    const $state = $injector.get('$state');\n    const $urlRouter = $injector.get('$urlRouter');\n\n    const enabledEvents = $stateEvents.provider.enabled();\n\n    const toParams = $transition$.params('to');\n    const fromParams = $transition$.params('from');\n\n    if (enabledEvents.$stateChangeSuccess) {\n      const startEvent = $rootScope.$broadcast(\n        '$stateChangeStart',\n        $transition$.to(),\n        toParams,\n        $transition$.from(),\n        fromParams,\n        $transition$.options(),\n        $transition$\n      );\n\n      if (startEvent.defaultPrevented) {\n        if (enabledEvents.$stateChangeCancel) {\n          $rootScope.$broadcast(\n            '$stateChangeCancel',\n            $transition$.to(),\n            toParams,\n            $transition$.from(),\n            fromParams,\n            $transition$.options(),\n            $transition$\n          );\n        }\n        // Don't update and resync url if there's been a new transition started. see issue #2238, #600\n        if ($state.transition == null) $urlRouter.update();\n        return false;\n      }\n\n      // right after global state is updated\n      const successOpts = { priority: 9999 };\n      $transition$.onSuccess(\n        {},\n        function() {\n          $rootScope.$broadcast(\n            '$stateChangeSuccess',\n            $transition$.to(),\n            toParams,\n            $transition$.from(),\n            fromParams,\n            $transition$.options(),\n            $transition$\n          );\n        },\n        successOpts\n      );\n    }\n\n    if (enabledEvents.$stateChangeError) {\n      $transition$.promise['catch'](function(error) {\n        if (error && (error.type === 2 /* RejectType.SUPERSEDED */ || error.type === 3) /* RejectType.ABORTED */)\n          return;\n\n        const evt = $rootScope.$broadcast(\n          '$stateChangeError',\n          $transition$.to(),\n          toParams,\n          $transition$.from(),\n          fromParams,\n          error,\n          $transition$.options(),\n          $transition$\n        );\n\n        if (!evt.defaultPrevented) {\n          $urlRouter.update();\n        }\n      });\n    }\n  }\n\n  stateNotFoundHandler.$inject = ['$to$', '$from$', '$state', '$rootScope', '$urlRouter'];\n  function stateNotFoundHandler($to$: TargetState, $from$: TargetState, injector: UIInjector): HookResult {\n    const $state: StateService = injector.get('$state');\n    const $rootScope: IScope = injector.get('$rootScope');\n    const $urlRouter: UrlRouter = injector.get('$urlRouter');\n\n    interface StateNotFoundEvent extends IAngularEvent {\n      retry: Promise<any>;\n    }\n\n    const redirect = { to: $to$.identifier(), toParams: $to$.params(), options: $to$.options() };\n    const e = <StateNotFoundEvent>$rootScope.$broadcast('$stateNotFound', redirect, $from$.state(), $from$.params());\n\n    if (e.defaultPrevented || e.retry) $urlRouter.update();\n\n    function redirectFn(): TargetState {\n      return $state.target(redirect.to, redirect.toParams, redirect.options);\n    }\n\n    if (e.defaultPrevented) {\n      return false;\n    } else if (e.retry || !!$state.get(redirect.to)) {\n      return e.retry && isFunction(e.retry.then) ? e.retry.then(redirectFn) : redirectFn();\n    }\n  }\n\n  $StateEventsProvider.$inject = ['$stateProvider'];\n  function $StateEventsProvider($stateProvider: StateProvider) {\n    $StateEventsProvider.prototype.instance = this;\n\n    interface IEventsToggle {\n      [key: string]: boolean;\n      $stateChangeStart: boolean;\n      $stateNotFound: boolean;\n      $stateChangeSuccess: boolean;\n      $stateChangeError: boolean;\n    }\n\n    let runtime = false;\n    const allEvents = ['$stateChangeStart', '$stateNotFound', '$stateChangeSuccess', '$stateChangeError'];\n    const enabledStateEvents = <IEventsToggle>allEvents.map(e => [e, true]).reduce(applyPairs, {});\n\n    function assertNotRuntime() {\n      if (runtime) throw new Error('Cannot enable events at runtime (use $stateEventsProvider');\n    }\n\n    /**\n     * Enables the deprecated UI-Router 0.2.x State Events\n     * [ '$stateChangeStart', '$stateNotFound', '$stateChangeSuccess', '$stateChangeError' ]\n     */\n    this.enable = function(...events: string[]) {\n      assertNotRuntime();\n      if (!events || !events.length) events = allEvents;\n      events.forEach(event => (enabledStateEvents[event] = true));\n    };\n\n    /**\n     * Disables the deprecated UI-Router 0.2.x State Events\n     * [ '$stateChangeStart', '$stateNotFound', '$stateChangeSuccess', '$stateChangeError' ]\n     */\n    this.disable = function(...events: string[]) {\n      assertNotRuntime();\n      if (!events || !events.length) events = allEvents;\n      events.forEach(event => delete enabledStateEvents[event]);\n    };\n\n    this.enabled = () => enabledStateEvents;\n\n    this.$get = $get;\n    $get.$inject = ['$transitions'];\n    function $get($transitions: TransitionService) {\n      runtime = true;\n\n      if (enabledStateEvents['$stateNotFound']) $stateProvider.onInvalid(stateNotFoundHandler);\n      if (enabledStateEvents.$stateChangeStart) $transitions.onBefore({}, stateChangeStartHandler, { priority: 1000 });\n\n      return {\n        provider: $StateEventsProvider.prototype.instance,\n      };\n    }\n  }\n\n  angular\n    .module('ui.router.state.events', ['ui.router.state'])\n    .provider('$stateEvents', ($StateEventsProvider as any) as IServiceProviderFactory)\n    .run([\n      '$stateEvents',\n      function($stateEvents: any) {\n        /* Invokes $get() */\n      },\n    ]);\n})();\n"
  ],
  "names": [
    "ng_from_import.module",
    "angular"
  ],
  "mappings": "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"
}