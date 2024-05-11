# INNODB logging

Makes CiviCRM use the INNODB, rather than Archive table format for detailed logging. Also compress existing InnoDB log tables.

The INNODB format is arguably a better format for CiviCRM logging. Although INNODB tables take more space, they can be queried much more effectively, which is useful when you want to consult the logs. Consulting the change log for ARCHIVE tables is prohibitively slow once your logging has been running a while.

## Installation

1. Install this extension.
1. Run `System.updatelogtables` API to convert existing log tables to InnoDB. Set `updateChangedEngineConfig=1` if your log tables are already InnoDB but uncompressed and want to compress them now. 

## See also

* https://civicrm.org/blog/eileen/who-did-what-when - a blog post explaining the motivations behind this extension in more detail
* https://docs.civicrm.org/sysadmin/en/latest/setup/logging/ for more information on logging
