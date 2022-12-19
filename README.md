# Module Loop Mini Tracker

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
To track product add to cart event

## Installation
\* = in production please use the `--keep-generated` option

### Zip file

 - Unzip the zip file in Magento root directory
 - Enable the module by running `php bin/magento module:enable Loop_MiniTracker`
 - Apply database updates by running `php bin/magento setup:upgrade`
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

Enable from **Store > Configuration > Loop > Mini Tracker**.

<img src="20221219-091808.png" />


## Specifications

- GET <base_url>/rest/V1/tracking?searchCriteria[pageSize]=20
  





## Attributes

