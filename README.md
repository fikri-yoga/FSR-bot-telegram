# FSR-bot-telegram

<p>A Telegram's bot that used for Field Services Reporting (FSR). It's designed for use by Field Services companies for reporting activities on customer visits.</p>

<h2>Introduction</h2>

<p>Telegram is an instant messaging service that allows for the creation of bots. Bots can be configured to send and receive messages. 
Using the fuction of that bot will make it easier for companies to conduct visit reporting activities, make it easier for technicians in reporting, minimize reporting errors, easy to use, easy to maintain data, and of course ... free!!</p>

<h2>Getting Started</h2>

<p>To generate your new Bot, you need an Access Token. <a href="https://telegram.me/botfather">Talk to BotFather</a> and follow a few simple steps described <a href="https://core.telegram.org/bots#botfather">here.</a></p>

<p>Change the parameters such as database host, database user, database name, database password, and Telegram Bot API Token in config.php file in the config folder. This Bot uses the webhook method, so you also have to set the <a href="https://core.telegram.org/bots/api#getting-updates">webhook</a> on Bot that you created earlier by using the <strong>hook.php</strong> file on this repository</p>

<p>To monitor the results of visits, you can see it using the <strong>index.php</strong> file on this repository by adding the date info at the end of the URL.</p>

<h2>Features</h2>

<p>In FSR-Bot v.1.0., the command format uses lines of words beginning with the "/" character and between data separated by the character "_". In addition, the output that will be displayed by this Bot is a line of text containing reporting status information. Here is a list of commands that this Bot covers :</p>

<table>
  <tr>
    <td align="center"><strong>Command</strong></td>
    <td align="center"><strong>Format</strong></td>
    <td align="center"><strong>Usage</strong></td>
  </tr>
  <tr>
    <td>done</td>
    <td>/done_tid</td>
    <td>Used to report the status of a successful visit</td>
  </tr>
  <tr>
    <td>problem</td>
    <td>/problem_tid_remark_information</td>
    <td>Used to report the status of a unsuccessful visit</td>
  </tr>
  <tr>
    <td>checktid</td>
    <td>/checktid_tid</td>
    <td>Used to check whether the customer is on the list that must be visited</td>
  </tr>
  <tr>
    <td>progress</td>
    <td>/progress</td>
    <td>Used to check the number of reports received today</td>
  </tr>
  <tr>
    <td>location</td>
    <td>/location_tid</td>
    <td>Used to report current customer locations</td>
  </tr>
  <tr>
    <td>getlocation</td>
    <td>/getlocation_tid</td>
    <td>Used to check the last location of the customers who had previously been reported</td>
  </tr>
  <tr>
    <td>imei</td>
    <td>/imei_tid</td>
    <td>Used to report the IMEI number of the device</td>
  </tr>
  <tr>
    <td>simcard</td>
    <td>/simcard_tid</td>
    <td>Used to report the simcard number of the device</td>
  </tr>
</table>

<p>The full Telegram Bot API documentation can be read <a href="https://core.telegram.org/bots/api">here</a>. If there is a feature you would like added to this Bot please either raise a Github issue or please feel free to raise a Pull Request.</p>

