=== Sailthru Triggermail ===
Contributors: jontasc
Tags: sailthru, triggermail, email, esp
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 1.1

Integrate Sailthru's Triggermail API functionality into your WordPress blog.

== Description ==

Triggermail provides email expertise and delivery monitoring of your transactional and mass emails, helping you engage your users and get in their Inbox.

Through our network of advertising companies we can help monetize your emails early on in the growth of your site.

**Quick Facts**

*   Monitored inbox delivery into the major ISP's of all your email
*   Simple email template management of both marketing and transactional emails
*   A/B Testing
*   Google analytics integration - puts your user's clicks right into your stats
*   Easy list opt-in
*   Auto email authentication
*   Delivery statistics on click through, optouts, spam reports
*   Link rewriting with your own domain name
*   List management (as many lists as you want)
*   Built in email authentication function
*   Contact management with attribute data
*   Easily integrated

**Full Email Delivery Reporting Features**

Access to metrics is valuable to all businesses and we provide reports in the control panel of each account. Our system can transfer reporting into Google analytics so that exact traffic can be recorded from each individual type of email.

With integration into Google Analytics you'll know exactly how effective your messages are. Couple that with our A/B testing and you can see which welcome message is more effective!

**Ease of Integration**

The API is easily integrated into PHP, Python, and Ruby, and the Triggermail website provides access to all of the settings and template editing. Our proprietary email software is built in Java and has been built to easily scale on demand and send messages in under 0.5 seconds.

The Triggermail API is a simple REST-based service. You can send email templates, check on the status of previous sends, and update templates remotely. We return data in your choice of JSON and serialized PHP.

We offer client libraries to easily integrate your website without knowing the intricacies of the API. We currently offer API client library code for PHP5, Ruby and Python.

**Global Infrastructure**

Where Triggermail really shines is our fully hosted email infrastructure, delivering real time instant delivery status reporting for all your email campaigns and automated site emails. You'll never have to worry about maintaining your own email servers for high volume email delivery again.

We have 2 redundant systems in both London and New York running a series of small clusters, which not only improves delivery efficiencies but allows us a dynamic failover in the event of a failure in either system.

== Installation ==

1. Upload the plugin folder `sailthru-triggermail` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. In your admin area, go to Settings -> Sailthru
1. In the 'General Options' section, enter your API key and secret.  If you do not have one, please contact us at [Sailthru.com](http://www.sailthru.com) for assistance.

== Frequently Asked Questions ==

= How do I create a newsletter signup form? =

In the 'Edit Forms' section, you can create, edit and delete all of your forms.  This section contains more detailed instructions for building the forms in HTML and embedding them on your website.

= How do I send a blast? =

Blasts are sent from the 'Send an Email Blast' section.  You can load a saved template (created on our [website](http://www.sailthru.com)) or create a new one right on this page.  If you have configured datafeeds (see below) you can also prefill the blast body from a feed.

= Can I use Triggermail to send all of my WordPress emails? =

You can turn this feature on in the 'General Options' section.

= When someone signs up for my newsletter, can I send them a welcome email? =

The 'General Options' section contains a checkbox to enable this.  Once enabled, you will be able to choose a template from your Sailthru account to be sent.  You may use any replacement fields that exist for the signup form (e.g. "first_name", "last_name").

= Can I integrate Horizon with my blog? =

Enable this by setting the subdomain in 'General Options'.

= How do I create a datafeed? =

In the 'Manage Datafeed' section, you can add, edit and delete datafeeds.  Simply give them a name and provide the link to an RSS feed.  Once you do so they will be available in the "Send an Email Blast" section.

== Changelog ==

= 1.0 =
* Initial release