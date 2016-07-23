# whmcs-hook-slack
https://ilhamrizqi.com

WHMCS hook to Slack. Send notification to slack channel or user on ticket open and user reply.

## Installation

Just copy `slack.php` and `slack.json` to `$WHMCS_ROOT/includes/hooks` directory.

## Configuration

Edit file `slack.json` and change `hook_url` to your slack hook url.

```json
  {
    "hook_url"  : "your_slack_hook_url",
    "username"  : "WHMCS",
    "emoji"     : ":loudspeaker",
    "channel"   : "#whmcs",
    "adminuser" : "your_whmcs_admin_username"
  }
```
Explanation

* `hook_url`: your slack's hook URL
* `username`: whatever you want to display in slack channel
* `emoji`: emoji icon
* `channel`: Slack channel to receive the notification
* `adminuser`: WHMCS admin username to call WHMCS API admin function

## Done

Now, try open ticket in the client area. You should receive notification from WHMCS every ticket open and user reply.