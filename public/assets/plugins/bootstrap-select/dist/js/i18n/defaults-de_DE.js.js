{"version":3,"sources":["../../../js/i18n/defaults-de_DE.js"],"names":[],"mappings":";;;;;;;;;;;;;;;;;;;;;;;;AAAA,CAAC,QAAQ,CAAC,GAAG,CAAC,CAAC,CAAC;AAChB,EAAE,EAAE,EAAE,CAAC,YAAY,CAAC,QAAQ,CAAC,CAAC,CAAC,CAAC,CAAC;AACjC,IAAI,gBAAgB,CAAC,CAAC,CAAC,KAAK,CAAC,CAAC,CAAC,IAAI,KAAK,CAAC;AACzC,IAAI,eAAe,CAAC,CAAC,CAAC,KAAK,CAAC,UAAU,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,GAAG,CAAC;AACjD,IAAI,iBAAiB,CAAC,CAAC,QAAQ,CAAC,CAAC,WAAW,CAAC,CAAC,QAAQ,CAAC,CAAC,CAAC,CAAC;AAC1D,MAAM,MAAM,CAAC,CAAC,WAAW,CAAC,EAAE,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,EAAE,CAAC,CAAC,CAAC,OAAO,CAAC,MAAM,CAAC,GAAG,CAAC,CAAC,CAAC,CAAC,EAAE,CAAC,CAAC,CAAC,QAAQ,CAAC,MAAM,CAAC,GAAG,EAAE,CAAC;AACxF,IAAI,EAAE,CAAC;AACP,IAAI,cAAc,CAAC,CAAC,QAAQ,CAAC,CAAC,MAAM,CAAC,CAAC,QAAQ,CAAC,CAAC,CAAC,CAAC;AAClD,MAAM,MAAM,CAAC,CAAC,CAAC;AACf,QAAQ,CAAC,MAAM,CAAC,EAAE,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,KAAK,CAAC,QAAQ,CAAC,EAAE,CAAC,CAAC,CAAC,OAAO,CAAC,GAAG,GAAG,CAAC,CAAC,CAAC,CAAC,KAAK,CAAC,QAAQ,CAAC,EAAE,CAAC,CAAC,CAAC,QAAQ,CAAC,GAAG,IAAI,CAAC;AACpG,QAAQ,CAAC,QAAQ,CAAC,EAAE,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,CAAC,OAAO,CAAC,KAAK,CAAC,QAAQ,CAAC,EAAE,CAAC,CAAC,CAAC,OAAO,CAAC,GAAG,GAAG,CAAC,CAAC,CAAC,CAAC,OAAO,CAAC,KAAK,CAAC,QAAQ,CAAC,EAAE,CAAC,CAAC,CAAC,QAAQ,CAAC,GAAG,GAAG,CAAC;AACrH,MAAM,EAAE,CAAC;AACT,IAAI,EAAE,CAAC;AACP,IAAI,aAAa,CAAC,CAAC,CAAC,KAAK,CAAC,IAAI,CAAC,IAAI,EAAE,CAAC;AACtC,IAAI,eAAe,CAAC,CAAC,CAAC,MAAM,CAAC,IAAI,CAAC,IAAI,EAAE,CAAC;AACzC,IAAI,iBAAiB,CAAC,CAAC,EAAE,CAAC,CAAC,CAAC;AAC5B,EAAE,EAAE,CAAC;AACL,GAAG,MAAM,EAAE,CAAC","file":"defaults-de_DE.js","sourcesContent":["(function ($) {\r\n  $.fn.selectpicker.defaults = {\r\n    noneSelectedText: 'Bitte wählen...',\r\n    noneResultsText: 'Keine Ergebnisse für {0}',\r\n    countSelectedText: function (numSelected, numTotal) {\r\n      return (numSelected == 1) ? '{0} Element ausgewählt' : '{0} Elemente ausgewählt';\r\n    },\r\n    maxOptionsText: function (numAll, numGroup) {\r\n      return [\r\n        (numAll == 1) ? 'Limit erreicht ({n} Element max.)' : 'Limit erreicht ({n} Elemente max.)',\r\n        (numGroup == 1) ? 'Gruppen-Limit erreicht ({n} Element max.)' : 'Gruppen-Limit erreicht ({n} Elemente max.)'\r\n      ];\r\n    },\r\n    selectAllText: 'Alles auswählen',\r\n    deselectAllText: 'Nichts auswählen',\r\n    multipleSeparator: ', '\r\n  };\r\n})(jQuery);\r\n"]}