# Module Loop Mini Tracker

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [API endpoint](#markdown-header-api-endpoint)


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

- Enable from **Store > Configuration > Loop > Mini Tracker**.

<img src="https://raw.githubusercontent.com/gelanivishal/loop-tracker/master/image.png" />


- Here is video of loop tracker extension

[![IMAGE ALT TEXT HERE](https://img.youtube.com/vi/CFU3byhu5hw/maxresdefault.jpg)](https://www.youtube.com/watch?v=CFU3byhu5hw)


## API endpoit

- GET <base_url>/rest/V1/tracking?searchCriteria[pageSize]=20
  
