> IMPORTANT: This code is made available in the hope that it will be useful, but **without any warranty**. See the GNU General Public License included with the code for more details. Automattic or WooCommerce support services are also not available to assist with the use of this code.

# WooCommerce Subscriptions - Cancel After Failed Retries

Cancel a subscription after all failed payment retry attempts have failed.

WooCommerce Subscriptions makes it possible to apply a set of custom [Retry Rules](https://docs.woocommerce.com/document/subscriptions/develop/failed-payment-retry/#section-3) to modify the behaviour of the Failed Payment Retry system. However, those rules only facilitate customizing the status applied at the time the retry rule is applied, not the status to be applied after the payment retry attempt is processed.

The default status applied to the order if a retry attempt fails is _failed_, and the status applied to the subscription is _on-hold_.

This plugin will transition both the order and related subscriptions for that order to _cancelled_ if all automatical payment retry attemps fail.

## Installation

To install:

1. Download the latest version of the plugin [here](https://github.com/Prospress/woocommerce-subscriptions-cancel-after-retryarchive/master.zip)
1. Go to **Plugins > Add New > Upload** administration screen on your WordPress site
1. Select the ZIP file you just downloaded
1. Click **Install Now**
1. Click **Activate**

### Updates

To keep the plugin up-to-date, use the [GitHub Updater](https://github.com/afragen/github-updater).

## Reporting Issues

If you find an problem or would like to request this plugin be extended, please [open a new Issue](https://github.com/Prospress/woocommerce-subscriptions-cancel-after-retryissues/new).

---

<p align="center">
	<a href="https://prospress.com/">
		<img src="https://cloud.githubusercontent.com/assets/235523/11986380/bb6a0958-a983-11e5-8e9b-b9781d37c64a.png" width="160">
	</a>
</p>
