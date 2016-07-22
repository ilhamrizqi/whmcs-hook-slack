# whmcs-hook-slack
https://ilhamrizqi.com

WHMCS hook to Slack. Send notification to slack channel or user on ticket open and user reply.

## Installation

Just copy `slack.php` and `slack.json` to `$WHMCS_ROOT/includes/hooks` directory.

## Configuration

Edit file `slack.php` and change `$adminuser = "ilham";` to your admin username. For example $adminuser = "admin"; This is used by the WHMCS local API call to get the username of the sender of the ticket.

Edit file `slack.json` and change `hook_url` to your slack hook url.

```json
  {
    "hook_url"  : "your_slack_hook_url",    
    "username"  : "WHMCS",                  
    "emoji"     : ":loudspeaker",
    "channel"   : "#whmcs"
  }
```
Explanation

* `hook_url`: your slack's hook URL
* `username`: whatever you want to display in slack channel
* `emoji`: emoji icon
* `channel`: Slack channel to receive the notification

## Done

Now, try open ticket in the client area. You should receive notification from WHMCS every ticket open and user reply.
