# Block Group

This module extends the standard Drupal block system with block groups. Each
block group provides a new block as well as a corresponding region. Child
blocks can be moved into any group region. The position and the settings of the
parent block are propagated to its children. Also block groups are nestable.

## Instructions

* Enable the Block Group module
* Enable the `administer blockgroups` permission for one or more admin roles
* Navigate to `/admin/structure/block_group_content`
* Click on the "Add group" button to add a new block group
