# laminas-memory

[![Build Status](https://github.com/laminas/laminas-memory/workflows/Continuous%20Integration/badge.svg)](https://github.com/laminas/laminas-memory/actions?query=workflow%3A"Continuous+Integration")

laminas-memory manages data in an environment with limited memory.

Memory objects (memory containers) are generated by the memory manager, and
transparently swapped/loaded when required.

For example, if creating or loading a managed object would cause the total memory
usage to exceed the limit you specify, some managed objects are copied to cache
storage outside of memory. In this way, the total memory used by managed objects
does not exceed the limit you need to enforce.

## Installation

Run the following to install this library:

```bash
$ composer require laminas/laminas-memory
```

## Documentation

Browse the documentation online at https://docs.laminas.dev/laminas-memory/

## Support

- [Issues](https://github.com/laminas/laminas-memory/issues/)
- [Chat](https://laminas.dev/chat/)
- [Forum](https://discourse.laminas.dev/)