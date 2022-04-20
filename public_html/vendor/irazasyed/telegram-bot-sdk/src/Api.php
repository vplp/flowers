<?php

namespace Telegram\Bot;

use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\UserProfilePhotos;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Commands\CommandInterface;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;


/**
 * Class Api
 *
 * @package Telegram\Bot
 */
class Api
{
    /**
     * @var string Version number of the Telegram Bot PHP SDK.
     */
    const VERSION = '1.0.0';

    /**
     * @var string The name of the environment variable that contains the Telegram Bot API Access Token.
     */
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * @var TelegramClient The Telegram client service.
     */
    protected $client;

    /**
     * @var string Telegram Bot API Access Token.
     */
    protected $accessToken = null;

    /**
     * @var TelegramResponse|null Stores the last request made to Telegram Bot API.
     */
    protected $lastResponse;

    /**
     * @var bool Indicates if the request to Telegram will be asynchronous (non-blocking).
     */
    protected $isAsyncRequest = false;

    /**
     * @var CommandBus|null Telegram Command Bus.
     */
    protected $commandBus = null;

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string                     $token                       The Telegram Bot API Access Token.
     * @param bool                       $async                       (Optional) Indicates if the request to Telegram
     *                                                                will be asynchronous (non-blocking).
     * @param string|HttpClientInterface $http_client_handler         (Optional) Custom HTTP Client Handler.
     *
     * @throws TelegramSDKException
     */
    public function __construct($token = null, $async = false, $http_client_handler = null)
    {
        $this->accessToken = isset($token) ? $token : getenv(static::BOT_TOKEN_ENV_NAME);
        if (!$this->accessToken) {
            throw new TelegramSDKException('Required "token" not supplied in config and could not find fallback environment variable "'.static::BOT_TOKEN_ENV_NAME.'"');
        }

        $httpClientHandler = null;
        if (isset($http_client_handler)) {
            if ($http_client_handler instanceof HttpClientInterface) {
                $httpClientHandler = $http_client_handler;
            } elseif ($http_client_handler === 'guzzle') {
                $httpClientHandler = new GuzzleHttpClient();
            } else {
                throw new \InvalidArgumentException('The HTTP Client Handler must be set to "guzzle", or be an instance of Telegram\Bot\HttpClients\HttpClientInterface');
            }
        }

        if (isset($async)) {
            $this->setAsyncRequest($async);
        }

        $this->client = new TelegramClient($httpClientHandler);
    }

    /**
     * Returns the TelegramClient service.
     *
     * @return TelegramClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns Telegram Bot API Access Token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Returns the last response returned from API request.
     *
     * @return TelegramResponse
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Sets the bot access token to use with API requests.
     *
     * @param string $accessToken The bot access token to save.
     *
     * @return Api
     *
     * @throws \InvalidArgumentException
     */
    public function setAccessToken($accessToken)
    {
        if (is_string($accessToken)) {
            $this->accessToken = $accessToken;

            return $this;
        }

        throw new \InvalidArgumentException('The Telegram bot access token must be of type "string"');
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param bool $isAsyncRequest
     *
     * @return TelegramRequest
     */
    public function setAsyncRequest($isAsyncRequest)
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest()
    {
        return $this->isAsyncRequest;
    }

    /**
     * Returns SDK's Command Bus.
     *
     * @return CommandBus
     */
    public function getCommandBus()
    {
        if (is_null($this->commandBus)) {
            return $this->commandBus = new CommandBus($this);
        }

        return $this->commandBus;
    }

    /**
     * Add Telegram Command to the Command Bus.
     *
     * @param CommandInterface|string $command
     *
     * @return CommandBus
     */
    public function addCommand($command)
    {
        return $this->getCommandBus()->addCommand($command);
    }

    /**
     * Add Telegram Commands to the Command Bus.
     *
     * @param array $commands
     *
     * @return CommandBus
     */
    public function addCommands(array $commands)
    {
        return $this->getCommandBus()->addCommands($commands);
    }

    /**
     * Returns list of available commands.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->getCommandBus()->getCommands();
    }

    /**
     * A simple method for testing your bot's auth token.
     * Returns basic information about the bot in form of a User object.
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @return User
     */
    public function getMe()
    {
        $response = $this->get('getMe');

        return new User($response->getDecodedBody());
    }

    /**
     * Send text messages.
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param int    $chat_id
     * @param string $text
     * @param bool   $disable_web_page_preview
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendMessage(
        $chat_id,
        $text,
        $disable_web_page_preview = false,
        $reply_to_message_id = null,
        $reply_markup = null
    ) {
        $params = compact('chat_id', 'text', 'disable_web_page_preview', 'reply_to_message_id', 'reply_markup');
        $response = $this->get('sendMessage', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Forward messages of any kind.
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @param int $chat_id
     * @param int $from_chat_id
     * @param int $message_id
     *
     * @return Message
     */
    public function forwardMessage($chat_id, $from_chat_id, $message_id)
    {
        $params = compact('chat_id', 'from_chat_id', 'message_id');
        $response = $this->get('forwardMessage', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Send Photos.
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param int    $chat_id
     * @param string $photo
     * @param string $caption
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendPhoto($chat_id, $photo, $caption = null, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'photo', 'caption', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendPhoto', $params);
    }

    /**
     * Send regular audio files.
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param int    $chat_id
     * @param string $audio
     * @param int    $duration
     * @param string $performer
     * @param string $title
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendAudio(
        $chat_id,
        $audio,
        $duration = null,
        $performer = null,
        $title = null,
        $reply_to_message_id = null,
        $reply_markup = null
    ) {
        $params = compact('chat_id', 'audio', 'duration', 'performer', 'title', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendAudio', $params);
    }

    /**
     * Send voice audio files.
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param int    $chat_id
     * @param string $voice
     * @param int    $duration
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendVoice($chat_id, $voice, $duration = null, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'voice', 'duration', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendVoice', $params);
    }

    /**
     * Send general files.
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param int    $chat_id
     * @param string $document
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendDocument($chat_id, $document, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'document', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendDocument', $params);
    }

    /**
     * Send .webp stickers.
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @param int    $chat_id
     * @param string $sticker
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     *
     * @throws TelegramSDKException
     */
    public function sendSticker($chat_id, $sticker, $reply_to_message_id = null, $reply_markup = null)
    {
        if (is_file($sticker) && (pathinfo($sticker, PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }

        $params = compact('chat_id', 'sticker', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendSticker', $params);
    }

    /**
     * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
     *
     * @see  sendDocument
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param int    $chat_id
     * @param string $video
     * @param int    $duration
     * @param string $caption
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendVideo(
        $chat_id,
        $video,
        $duration = null,
        $caption = null,
        $reply_to_message_id = null,
        $reply_markup = null
    ) {
        $params = compact('chat_id', 'video', 'duration', 'caption', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendVideo', $params);
    }

    /**
     * Send point on the map.
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param int    $chat_id
     * @param float  $latitude
     * @param float  $longitude
     * @param int    $reply_to_message_id
     * @param string $reply_markup
     *
     * @return Message
     */
    public function sendLocation($chat_id, $latitude, $longitude, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'latitude', 'longitude', 'reply_to_message_id', 'reply_markup');
        $response = $this->get('sendLocation', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Broadcast a Chat Action.
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @param int    $chat_id
     * @param string $action
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    public function sendChatAction($chat_id, $action)
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
        ];

        if (isset($action) && in_array($action, $validActions)) {
            return $this->get('sendChatAction', compact('chat_id', 'action'));
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
    }

    /**
     * Returns a list of profile pictures for a user.
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param int $user_id
     * @param int $offset
     * @param int $limit
     *
     * @return UserProfilePhotos
     */
    public function getUserProfilePhotos($user_id, $offset = null, $limit = null)
    {
        $response = $this->get('getUserProfilePhotos', compact('user_id', 'offset', 'limit'));

        return new UserProfilePhotos($response->getDecodedBody());
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param string $url         HTTPS url to send updates to.
     * @param string $certificate Upload your public key certificate so that the root certificate in use can be checked.
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    public function setWebhook($url, $certificate = null)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($url, PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }

        return $this->uploadFile('setWebhook', compact('url', 'certificate'));
    }

    /**
     * Returns webhook updates sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     *
     * @return Update
     */
    public function getWebhookUpdates()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        return new Update($body);
    }

    /**
     * Removes the outgoing webhook (if any).
     *
     * @return TelegramResponse
     */
    public function removeWebhook()
    {
        $url = '';

        return $this->get('setWebhook', compact('url'));
    }

    /**
     * Use this method to receive incoming updates using long polling.
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param int|null $offset
     * @param int|null $limit
     * @param int|null $timeout
     *
     * @return Update[]
     */
    public function getUpdates($offset = null, $limit = null, $timeout = null)
    {
        $response = $this->get('getUpdates', compact('offset', 'limit', 'timeout'));
        $updates = $response->getDecodedBody();

        $data = [];
        foreach ($updates['result'] as $update) {
            $data[] = new Update($update);
        }

        return $data;
    }

    /**
     * Builds a custom keyboard markup.
     *
     * @link https://core.telegram.org/bots/api#replykeyboardmarkup
     *
     * @param array $keyboard
     * @param bool  $resize_keyboard
     * @param bool  $one_time_keyboard
     * @param bool  $selective
     *
     * @return string
     */
    public function replyKeyboardMarkup(
        $keyboard,
        $resize_keyboard = false,
        $one_time_keyboard = false,
        $selective = false
    ) {
        return json_encode(compact('keyboard', 'resize_keyboard', 'one_time_keyboard', 'selective'));
    }

    /**
     * Hide the current custom keyboard and display the default letter-keyboard.
     *
     * @link https://core.telegram.org/bots/api#replykeyboardhide
     *
     * @param bool $selective
     *
     * @return string
     */
    public static function replyKeyboardHide($selective = false)
    {
        $hide_keyboard = true;

        return json_encode(compact('hide_keyboard', 'selective'));
    }

    /**
     * Display a reply interface to the user (act as if the user has selected the bot‘s message and tapped ’Reply').
     *
     * @link https://core.telegram.org/bots/api#forcereply
     *
     * @param bool $selective
     *
     * @return string
     */
    public static function forceReply($selective = false)
    {
        $force_reply = true;

        return json_encode(compact('force_reply', 'selective'));
    }

    /**
     * Processes Inbound Commands.
     *
     * @param bool $webhook
     *
     * @return Update|Objects\Update[]
     */
    public function commandsHandler($webhook = false)
    {
        if ($webhook) {
            $update = $this->getWebhookUpdates();
            $this->processCommand($update);

            return $update;
        }

        $updates = $this->getUpdates();
        $highestId = -1;

        foreach ($updates as $update) {
            $highestId = $update->getUpdateId();
            $this->processCommand($update);
        }

        //An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id.
        if ($highestId != -1) {
            $this->getUpdates($highestId + 1, 1);
        }

        return $updates;
    }

    /**
     * Check update object for a command and process.
     *
     * @param $update
     */
    protected function processCommand(Update $update)
    {
        $message = $update->getMessage();

        if ($message->has('text')) {
            $this->getCommandBus()->handler($message->getText(), $update);
        }
    }


    /**
     * Determine if a given type is the message.
     *
     * @param string $type
     * @param Update $update
     *
     * @return bool
     */
    public function isMessageType($type, Update $update)
    {
        if ($update->getMessage()->has(strtolower($type))) {
            return true;
        }

        return $this->detectMessageType($update) === $type;
    }

    /**
     * Detect Message Type Based on Update Object.
     *
     * @param Update $update
     *
     * @return string|null
     */
    public function detectMessageType(Update $update)
    {
        $types = ['audio', 'document', 'photo', 'sticker', 'video', 'voice', 'contact', 'location', 'text'];

        return $update->getMessage()
            ->keys()
            ->intersect($types)
            ->pop();
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    protected function get($endpoint, $params = [])
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            $params
        );
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    protected function post($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'POST',
            $endpoint,
            $params
        );
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return Message
     *
     * @throws TelegramSDKException
     */
    protected function uploadFile($endpoint, array $params = [])
    {
        $i = 0;
        $multipart_params = [];
        foreach ($params as $name => $contents) {
            if (is_null($contents)) {
                continue;
            }

            if (!is_resource($contents)) {
                $contents = is_file($contents) ? (new InputFile($contents))->open() : (string)$contents;
            }

            $multipart_params[$i]['name'] = $name;
            $multipart_params[$i]['contents'] = $contents;
            ++$i;
        }

        $response = $this->post($endpoint, [
            'multipart' => $multipart_params,
        ]);

        return new Message($response->getDecodedBody());
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    protected function sendRequest(
        $method,
        $endpoint,
        array $params = []
    ) {
        $request = $this->request($method, $endpoint, $params);

        return $this->lastResponse = $this->client->sendRequest($request);
    }

    /**
     * Instantiates a new TelegramRequest entity.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramRequest
     */
    protected function request(
        $method,
        $endpoint,
        array $params = []
    ) {
        return new TelegramRequest(
            $this->getAccessToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest()
        );
    }

    /**
     * Magic method to process any "get" requests.
     *
     * @param $method
     * @param $arguments
     *
     * @return bool|TelegramResponse
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 3);
        if ($action === 'get') {
            /** @noinspection PhpUndefinedFunctionInspection */
            $class_name = studly_case(substr($method, 3));
            $class = 'Telegram\Bot\Objects\\'.$class_name;
            $response = $this->get($method, $arguments[0] ?: []);

            if (class_exists($class)) {
                return new $class($response->getDecodedBody());
            }

            return $response;
        }

        return false;
    }
}
