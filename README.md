#  PasswordConfirm plugin for Craft CMS 3.x
A little helper for you to confirm passwords match on front end forms

This plugin *does not* use it's own controller to save the user, so it doesn't override or bypass any of Crafts own methods, so it's all good :)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require christopherdosin/password-confirm

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for PasswordConfirm.

## Using PasswordConfirm

You just need to add a `passwordConfirm` field to your *front end* user registration form, like so:

```html
<input type="password" name="passwordConfirm">
{% if account is defined %}
  {{ account.getErrors('passwordConfirm') }}
{% endif %}
```

Then when the user submits, passwordconfirm listens for the event and checks whether the two strings match and if not will add errors to the user model, stop the save process and return you to your form.
