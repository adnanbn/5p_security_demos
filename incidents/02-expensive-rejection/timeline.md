# Timeline

- **10:40** - Normal partner API traffic and healthy worker capacity.
- **10:41** - Automated probes begin requesting common secret, backup, and debug paths.
- **10:42** - PHP-FPM reaches maximum active workers; database waits and the listen queue rise.
- **10:43** - Legitimate partner requests time out.
- **10:44** - Edge blocks are added for the probing paths and source patterns.
- **10:47** - Capacity recovers while the application rejection path is investigated.