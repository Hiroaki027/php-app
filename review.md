# PHP App ① レビュー

## 全般

### 以下のaタグのリンクを押下した際にedit.phpの$_GETにどんな値が格納されるか説明してください。

```html
<a href="edit.php?todo_id=123&todo_content=焼肉">更新</a>
```

* todosテーブルの`id`というキーに`123`というバリューと、`content`というキーに'焼肉'といったバリューが格納される

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

### `header('location: ./index.php')`は何をしているか説明してください。

* リダイレクト先として`index.php`を指定している。
```php
createData($_POST);
header('Location: ./index.php');
```
* `createData($_POST)`後に`header('location: ./index.php')`で遷移するようになっている。

### `getRefererPath()`は何をしているか説明してください。

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

### `updateTodoData($post)`は何をしているか説明してください。

## 削除

### `deleteTodoData($id)`は何をしているか説明してください。

### `deleted_at`を現在時刻で更新すると一覧画面からToDoが非表示になる理由を説明してください。

### 今回のように実際のデータを削除せずに非表示にすることで削除されたように扱うことを〇〇削除というか。

### 実際にデータを削除することを〇〇削除というか。

### 前問のそれぞれの削除のメリット・デメリットについて説明してください。
