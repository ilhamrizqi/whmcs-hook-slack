<?php
/**
 * Slack notification hook
 *
 * @package    Slack
 * @author     Ilham Rizqi Sasmita <irs@sandiloka.com>
 * @copyright  Copyright (c) Ilham Rizqi Sasmita
 * @license    MIT License
 * @version    $Id$
 * @link       https://github.com/ilhamrizqi/whmcs-hook-slack
 */



if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function get_client_name($clientid)
{
    $client = "";
    $command = "getclientsdetails";
    $adminuser = "ilham";
    $values["clientid"] = $clientid;
    $values["pid"] = $pid;

    $results = localAPI($command,$values,$adminuser);

    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $results, $values, $tags);
    xml_parser_free($parser);

    $data = array();
    if($results["result"] == "success")
    {
        $client = $results["firstname"]." ".$results["lastname"];
        $client = trim($client);
        $company = $results["companyname"];
        if($company != "")
        {
            $client .= " (".$company.")";
        }
    }
    else
    {
        $client = "Error";
    }

    return $client;
}

function slack_post($text)
{
    $text = file_get_contents("slack.json");
    $config = json_decode($text, true);
    $url = $config['url'];    
    $payload = array
    (
        "text"          => $text,
        "username"      => $config["username"],
        "icon_emoji"    => $config["emoji"],
        "channel"       => $config["channel"]
    );

    $data = "payload=".json_encode($payload);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

}

function hook_slack_ticketopen($vars)
{

    $ticketid = $vars['ticketid'];
    $userid = $vars['userid'];
    $deptid = $vars['deptid'];
    $deptname = $vars['deptname'];
    $subject = $vars['subject'];
    $message = $vars['message'];
    $priority = $vars['priority'];
    $name = get_client_name($userid);

    $text  = "[ID: ".$ticketid."] ".$subject."\r\n";
    $text .= "User: ".$name."\r\n";
    $text .= "Departemen: ".$deptname."\r\n";
    //$text .= "Priority: ".$priority."\r\n";
    $text .= $message."\r\n";

    slack_post($text);
}

function hook_slack_ticketuserreply($vars)
{
    $ticketid = $vars['ticketid'];
    $userid = $vars['userid'];
    $deptid = $vars['deptid'];
    $deptname = $vars['deptname'];
    $subject = $vars['subject'];
    $message = $vars['message'];
    $priority = $vars['priority'];
    $name = get_client_name($userid);

    $text  = "[ID: ".$ticketid."] ".$subject."\r\n";
    $text .= "User: ".$name."\r\n";
    $text .= "Departemen: ".$deptname."\r\n";
    //$text .= "Priority: ".$priority."\r\n";
    $text .= $message."\r\n";

    slack_post($text);

}

add_hook("TicketOpen",      1, "hook_slack_ticketopen");
add_hook("TicketUserReply", 1, "hook_slack_ticketuserreply");

