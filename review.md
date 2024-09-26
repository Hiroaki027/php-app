# PHP App ① レビュー

## 全般

### 以下のaタグのリンクを押下した際にedit.phpの$_GETにどんな値が格納されるか説明してください。

```html
<a href="edit.php?todo_id=123&todo_content=焼肉">更新</a>
```

### 以下のフォームの送信ボタンを押下した際にstore.phpの$_POSTにどんな値が格納されるか説明してください。

```html
<form action="store.php" method="post">
    <input type="text" name="id" value="123">
		<textarea　name="content">焼肉</textarea>
    <button type="submit">送信</button>
</form>
```

### `require_once()` は何のために記述しているか説明してください。

### `savePostedData($post)`は何をしているか説明してください。

### `header('location: ./index.php')`は何をしているか説明してください。

### `getRefererPath()`は何をしているか説明してください。

### `connectPdo()` の返り値は何か、またこの記述は何をするための記述か説明してください。

### `try catch`とは何か説明してください。

### Pdoクラスをインスタンス化する際に`try catch`が必要な理由を説明してください。

## 新規作成

### `createTodoData($post)`は何をしているか説明してください。

## 一覧

### `getTodoList()`の返り値について説明してください。

### `<?= ?>`は何の省略形か説明してください。

## 更新

### `getSelectedTodo($_GET['id'])`の返り値は何か、またなぜ`$_GET['id']` を引数に渡すのか説明してください。

### `updateTodoData($post)`は何をしているか説明してください。

## 削除

### `deleteTodoData($id)`は何をしているか説明してください。

### `deleted_at`を現在時刻で更新すると一覧画面からToDoが非表示になる理由を説明してください。

### 今回のように実際のデータを削除せずに非表示にすることで削除されたように扱うことを〇〇削除というか。

### 実際にデータを削除することを〇〇削除というか。

### 前問のそれぞれの削除のメリット・デメリットについて説明してください。
