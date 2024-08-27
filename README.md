<h1 align="center">element119 | Admin OpCache Report</h1>

## 📝 Features
✔️ Provides a current health check of the PHP OpCache

✔️ Flush PHP OpCache from the admin

✔️ Theme agnostic

✔️ Built in accordance with Magento best practises

✔️ Dedicated module configuration section and custom admin user controls

✔️ Seamless integration with Magento

✔️ Built with developers and extensibility in mind to make customisations as easy as possible

✔️ Installable via Composer

⏳ Logging of OpCache statistics for temporal analysis

⏳ Data visualisation

<br/>

## 🔌 Installation
Run the following command to *install* this module:
```bash
composer require element119/module-admin-opcache-report
php bin/magento setup:upgrade
```

<br/>

## ⏫ Updating
Run the following command to *update* this module:
```bash
composer update element119/module-admin-opcache-report
php bin/magento setup:upgrade
```

<br/>

## ❌ Uninstallation
Run the following command to *uninstall* this module:
```bash
composer remove element119/module-admin-opcache-report
php bin/magento setup:upgrade
```

<br/>

## 📚 User Guide
Configuration for this module can be found in the Magento admin under `Stores -> Settings -> Configuration -> Advanced
-> System -> PHP OpCache Report`.

<br>

### OpCache Report
The OpCache information can be found in the admin under `System -> Tools -> PHP OpCache Report`.

<br>

### Memory Units
The units used when referencing memory in the OpCache report. The default value is `GB`.

<br>

### Float Precision
The number of decimal places to use in the OpCache report.

<br>

### Date Format
The date format to use in the OpCache report. Supports
[PHP date formats](https://www.php.net/manual/en/datetime.format.php).

<br>

## 📸 Screenshots & GIFs
### Report - OpCache Disabled
![e119-opcache-report-disabled](https://github.com/user-attachments/assets/159b9649-0b9a-4833-ac06-eb0ef3a49193)

### Report - OpCache Enabled
![e119-opcache-report-enabled](https://github.com/user-attachments/assets/0fc0e43c-3ede-49b8-a7ba-12d609e82e4b)
