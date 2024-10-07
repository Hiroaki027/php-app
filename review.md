# PHP App ① レビュー

## 全般

### 以下のaタグのリンクを押下した際にedit.phpの$_GETにどんな値が格納されるか説明してください。

```html
<a href="edit.php?todo_id=123&todo_content=焼肉">更新</a>
```

```php
[
    'id' => 123,
    'content' => '焼肉'
]
```

### 以下のフォームの送信ボタンを押下した際にstore.phpの$_POSTにどんな値が格納されるか説明してください。

```html
<form action="store.php" method="post">
    <input type="text" name="id" value="123">
		<textarea　name="content">焼肉</textarea>
    <button type="submit">送信</button>
</form>
```

```php
[
    'id' => 123,
    'content' => '焼肉'
]
```

### `require_once()` は何のために記述しているか説明してください。

* ファイルの読み込みです。また、`require_once`は`include_once`と違い、エラーが起きた際に<br>スクリプト処理が止まります。

### `savePostedData($post)`は何をしているか説明してください。

* 条件に合わせて、投稿に対する処理を行っている。

```php
function savePostedData($post)
{
    $path = getRefererPath();
    switch ($path) {
        case '/new.php':
            createTodoData($post['content']);
            break;
        case '/edit.php':
            updateTodoData($post);
            break;
        case '/index.php':
            deleteTodoData($post['id']);
            break;
        default:
            break;
    }
}

function getRefererPath()
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    return $urlArray['path'];
}
```
大まかな流れとして
1.`store.php`内の関数`savePostedData($_POST);`の引数を<br>関数`savePostedData($post)`の引数に代入している。<br>
2.プロパティの`$path`に関数`getRefererPath()`内で受けとったURLを代入している。<br>
3.switch文の条件として`$path`を指定し、`$path`内に応じて`case`の処理を実行している。

### `header('location: ./index.php')`は何をしているか説明してください。

* リダイレクト先として`index.php`を指定している。
```php
createData($_POST);
header('Location: ./index.php');
```
* `createData($_POST)`後に`header('location: ./index.php')`で遷移するようになっている。

### `getRefererPath()`は何をしているか説明してください。

* ページへリクエストの送り元のURLを取得し`path`を返している。

```php
function getRefererPath()
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    return $urlArray['path'];
}
```
* プロパティ`$urlArray`に対して`parse_url($_SERVER['HTTP_REFERER']);`を代入し
　ここで`parse_url`関数の引数としてスーパーグローバル変数である`$_SERVER`を用い
　かつ、配列内に`['HTTP_REFERE']`を用いることでHTTPヘッダー名をREFERE、つまりは経由元の情報を取得し
　`parse_url`によりURL情報を解析し文字列として返している。
　その値を、`return $urlArray['path'];` の記述により`path`として返している。

### `connectPdo()` の返り値は何か、またこの記述は何をするための記述か説明してください。

* 返り値は`new PDO(DSN, DB_USER, DB_PASSWORD)`とあるので、PDOインスタンスを返しています。
```php
function connectPdo()
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}
```
* また、データベースサーバーとの接続をする為に記述しています。

### `try catch`とは何か説明してください。

* `try catch`は例外処理に対応するための記述です。
* `try{}`内の処理で発生した例外を補足します。
* `catch{}`内に補足した例外に対しての対処内容を記述します。

### Pdoクラスをインスタンス化する際に`try catch`が必要な理由を説明してください。

* 例外処理としてデータベースの値を操作する処理に該当するからです。
* また、`require_once`で名前を指定してファイルを開く処理も<br>例外処理に該当する1つだといえます。

## 新規作成

### `createTodoData($post)`は何をしているか説明してください。

* データベース内の`todos`テーブルの`contnt`カラムにバリューを新規作成している。
```php
createData($_POST);
```
* からstore.php内の`createData($post)`関数が呼び出され
```php
function createData($post)
{
  createTodoData($post['content']);
}
```
* function.php内の`createTodoData($post['content'])`関数が呼び出され
```php
function createTodoData($todoText)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (content) VALUES ("' . $todoText . '")';
    $dbh->query($sql);
}
```
* ここで、`dbh->query($sql)`の記述により
`$sql = 'INSERT INTO todos (content) VALUES ("' . $todoText . '")'`
がデータベース内で実行されている。

## 一覧

### `getTodoList()`の返り値について説明してください。

* `todos`テーブルのすべてのレコードが返り値として返されています。
```php
function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    return $dbh->query($sql)->fetchAll();
}
```
* つまり、`getALLRcords`関数で定義されている<br>`$sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';`によって<br>データベース内のカラムを絞り込み表示するクエリを`$dbh->query($sql)`で実行し<br>更に`fetchAll();`で取得したデータを全件表示させている。

### `<?= ?>`は何の省略形か説明してください。

* `echo`の省略形です。HTMLと混在してPHPタグの中で出力したい場合は`<?= ?>`を使います。

## 更新

### `getSelectedTodo($_GET['id'])`の返り値は何か、またなぜ`$_GET['id']` を引数に渡すのか説明してください。

* `return getTodoTextById($id);`とあるので、`getTodoTextById($id)`関数を返しています。
つまりは、`getTodoTextById($id)`関数内の処理である`$data['content'];`を返しています。
<br>
* また、引数として`$_GET['id']`を指定している理由として、レコードの絞り込みに必要だからです。
`$_GET['id']`を、`getSelectedTodo($id)`関数を通じて`getTodoTextById($id);`関数に渡り
最終的にプロパティ`$sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id ='.$id;`の記述により
「`todos`テーブルの`deleted_at`カラムがNULLかつ`id`カラムが`$id`のもの」と指定する際に必要となります。

```php
function getSelectedTodo($id)
{
    return getTodoTextById($id);
}
```

```php
function getTodoTextById($id)
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id ='.$id;
    $data = $dbh->query($sql)->fetch();
    return $data['content'];
}
```

### `updateTodoData($post)`は何をしているか説明してください。

* 既存の投稿物を更新しています。

```php
function updateTodoData($post)
{
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET content = "' . $post['content'] . '" WHERE id = ' . $post['id'];
    $dbh->query($sql);
}
```
* `$sql = 'UPDATE todos SET content = "' . $post['content'] . '" WHERE id = ' . $post['id'];`で
データベースで実行するクエリを記述しており、`UPDATE todos SET content = "' . $post['content'] `内の
`WHERE id = ' . $post['id'`でIDカラムを軸に変更をかけたい投稿物のIDで絞り込みを行い
`content`カラムの中身を`$post['content']`の内容に変更しています。
そして、`$dbh->query($sql);`実際にクエリを実行するように命令しています。

## 削除

### `deleteTodoData($id)`は何をしているか説明してください。

* 既存の投稿物を論理削除しています。

```php
function deleteTodoData($id)
{
    $dbh = connectPdo();
    $now = date('Y-m-d H:i:s');
    $sql = 'UPDATE todos SET deleted_at = "'.$now.'" WHERE id ='.$id;
    $dbh->query($sql);
}
```

* `$sql = 'UPDATE todos SET deleted_at = "'.$now.'" WHERE id ='.$id;`で
データベースで実行するクエリを記述しており、`'UPDATE todos SET deleted_at = "'.$now.'" WHERE id ='.$id;`内の
`WHERE id ='.$id;`でIDカラムを軸に変更をかけたい投稿物のIDで絞り込みを行い
`'UPDATE todos SET deleted_at = "'.$now.`で`deleted_at`カラムの中身を`$now`の内容である
現在時刻に変更しています。そして、`$dbh->query($sql);`実際にクエリを実行するように命令しています。

### `deleted_at`を現在時刻で更新すると一覧画面からToDoが非表示になる理由を説明してください。

* 一覧画面に表示するレコードの条件として`deleted_at`カラムがNULLのものとして絞り込みをかけているからです。<br>

**connection.php**内
```php
function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    return $dbh->query($sql)->fetchAll();
}
```

### 今回のように実際のデータを削除せずに非表示にすることで削除されたように扱うことを〇〇削除というか。

* 論理削除といいます。

### 実際にデータを削除することを〇〇削除というか。

* 物理削除といいます。

### 前問のそれぞれの削除のメリット・デメリットについて説明してください。

#### 論理削除
1.メリット
扱いとしては削除であるがデータは残っている為、誤って削除したとしても復旧が可能であることです。<br>
2.デメリット
データとして残り続けてしまう為、もしセキュリティの脆弱性を突かれた場合、データ漏洩のリスクがあるということです。

#### 物理削除
1.メリット
データごと削除している為、セキュリティの脆弱性を突かれたとしても、データが漏洩することがないことです。<br>
2.デメリット
データごと削除しているので、誤って削除した場合は取り返しがつかなくなります。つまりは、復旧ができないことです。