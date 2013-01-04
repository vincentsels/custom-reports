
# Custom Reports

*Copyright (C) 2012 Vincent Sels*

## Summary

Custom Reports is a plugin for the open source [MantisBT](http://www.mantisbt.org) tool (also check out its [Github](https://github.com/mantisbt) page). With this plugin, you can easily integrate custom reports, based on self-written sql queries.

## Features

* Use the configuration page to add or change custom reports.
* Specify a name and a required minimal access level to be able to view the report.
* Optionally specify that this report requires a period to be entered.
* Access these reports from the menu bar.
* Basic security checks: query is not parsed, but DML, DDL and DCL keywords are not allowed.

## Dependencies

* [jQuery library](https://github.com/mantisbt-plugins/jquery)
* [Array export to Excel](https://github.com/vincentsels/array-export-excel)