# exportToExcel
MODX snippet to export resource data to excel.

## What does this snippet actually do?

As the name suggests, this snippet will export all specified field data from any resources on a MODX site into an excel document (exciting!). It is flexible enough to pull any type of data, and also process any fields before export.

## Options to help you do the do


| Name                      | Type              | Default  Value  | Description                                                                                                                              |
| -----------------------|-----------------|-----------------|-----------------------------------------------------------------------------------------------------------------|
| parent                |string              | '0'     | Defines a parent resource for the search to search the children of.                                  |
| fields                |string              | 'id[Resource id],pagetitle[Title],longtitle[Longtitle],description[Description]'     | Defines the fields to export  (more info on how this should be formatted below.)                               |
| includeUnpublished                |boolean              | 0     | Flag to determine if unpublished resources should be included.                                  |
| filename                |string              | 'Exported Data'     | Name for the final exported excel sheet (this will be appended with a date/time).                                  |


### Fields

The fields to be exported should be passed as a comma seperated list. Resource fields should be specified as normal, but template variables must be defined starting with _TV._.

``pagetitle,longtitile,TV.myTemplateVariable``

Fields can also be processed before being inserted into the excel sheet by specifiing an output modifier. This is done using a _:_ as you would when outputting a TV into a template.

``pagetitle,longtitile,TV.myTemplateVariable:myOutputModifier``

