<?php
// 需要安装Swoole
class WebSocketServer
{
  private $config;
  private $table;
  private $server;

  public function __construct()
  {
    // 内存表 实现进程间共享数据，也可以使用redis替代
    $this->createTable();
    // 实例化配置
    $this->config = [
      'host' => '0.0.0.0',
      'port' => 2019,
      'redis' => [
        'scheme' => 'tcp',
        'host' => '0.0.0.0',
        'port' => 6380
      ]
    ];
  }

  public function run()
  {
    $this->server = new \swoole_websocket_server(
      $this->config['host'],
      $this->config['port']
    );

    $this->server->on('open', [$this, 'open']);
    $this->server->on('message', [$this, 'message']);
    $this->server->on('close', [$this, 'close']);

    $this->server->start();
  }

  public function open(
    \swoole_websocket_server $server,
    \swoole_http_request $request
  ) {
    $user = [
      'fd' => $request->fd,
      'name' => $request->get['name']
    ];
    // 放入内存表
    $this->table->set($request->fd, $user);

    $server->push(
      $request->fd,
      json_encode([
        'user' => $user,
        'all' => $this->allUser(),
        'type' => 'openSuccess'
      ])
    );
    $this->pushMessage($server, $user['name'] . '进来了', 'join', $user['fd']);
  }

  private function allUser()
  {
    $users = [];
    foreach ($this->table as $row) {
      $users[] = $row;
    }
    return $users;
  }

  public function message(
    \swoole_websocket_server $server,
    \swoole_websocket_frame $frame
  ) {
    $data = json_decode($frame->data);
    $old_data = $this->table->get($frame->fd);
    // $old_data['x'] = $data->x;
    $old_data['name'] = $data->name;
    $old_data['message'] = $data->message;
    $this->table->set($frame->fd, $old_data);
    $this->pushMessage($server, $old_data['message'], 'message', $frame->fd);
  }

  /**
   * 推送消息
   *
   * @param \swoole_websocket_server $server
   * @param string $message
   * @param string $type
   * @param int $fd
   */
  private function pushMessage(
    \swoole_websocket_server $server,
    string $message,
    string $type,
    int $fd
  ) {
    $date_time = date('Y-m-d H:i:s', time());
    $user_data = $this->table->get($fd);

    foreach ($this->table as $item) {
      // 自己不用发送
      if ($item['fd'] == $fd) {
        $server->push(
          $item['fd'],
          json_encode(['type' => 'response', 'error' => false])
        );
        continue;
      }

      $server->push(
        $item['fd'],
        json_encode([
          'type' => $type,
          'message' => $message,
          'time' => $date_time,
          'fd' => $user_data['fd'],
          'name' => $user_data['name']
          // 'x' => $user_data['x'],
          // 'y' => $user_data['y']
        ])
      );
    }
  }

  /**
   * 客户端关闭的时候
   *
   * @param \swoole_websocket_server $server
   * @param int $fd
   */
  public function close(\swoole_websocket_server $server, int $fd)
  {
    $user = $this->table->get($fd);
    $this->pushMessage($server, $user['name'] . '离开了', 'close', $fd);
    $this->table->del($fd);
  }

  /**
   * 创建内存表
   */
  private function createTable()
  {
    $this->table = new \swoole_table(1024);
    $this->table->column('fd', \swoole_table::TYPE_INT);
    $this->table->column('name', \swoole_table::TYPE_STRING, 50);
    // $this->table->column('x', \swoole_table::TYPE_STRING, 50);
    // $this->table->column('y', \swoole_table::TYPE_STRING, 50);
    $this->table->column('message', \swoole_table::TYPE_STRING, 1024);
    $this->table->create();
  }

  public function tableCount()
  {
    return $this->table->count();
  }
}

$ws_server = new WebSocketServer();
$ws_server->run();
