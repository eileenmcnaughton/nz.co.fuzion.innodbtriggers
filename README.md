# INNODB logging

Makes CiviCRM use the INNODB, rather than Archive table format for detailed logging.

The INNODB format is arguablly a better format for CiviCRM logging. Although INNODB tables take more space, they can be queried much more effectively, which is useful when you want to consult the logs. Consulting the change log for ARCHIVE tables is phohibitivley slow once your logging has been running a while.

## See also

* https://civicrm.org/blog/eileen/who-did-what-when - a blog post explaining the motivations behind this extension in more detail
* https://docs.civicrm.org/sysadmin/en/latest/setup/logging/ for more information on logging
