# To-do App

### 更新紀錄
- [12/22] 完成基本所有功能，等待 mail server 驗證中 
- [12/08] 完成 CRUD 基本功能，與前端介面整合，並加上 with done 功能。然後把前端全部改成 fetch request。
- [12/07] 解掉 500(Internal server error) 問題，最後發現是 request type 問題。
- [12/06] 嘗試串接 API，遇到 Http 500 (Internal-server-error)
- [12/03] 初始化 laravel 環境、db schema、基本的關係
- [11/30] 完成 Udemy online course (86/309) 課程，已會使用 laravel 實作基本 one/many relationship、CRUD。<br>打算看到第 125 節後開始實做todo-app專案。預計明天完成線上課程。
- [11/25] 專案確立、確認規格、時程（12/24 前做完）

### To-do
- （ˇ）Finish Udemy's laravel online course.
- （ˇ）Build coding env. 
- （ˇ）Build/set db structure.
- （ˇ）Implement CRUD.
- （ˇ）Implement recording items whether it have done.
- （ˇ）Implement account system(Log-in / Log-out / Sign-in/).
- （ˇ）Implement 規格(No.5).
- （ˇ）Implement 規格(No.6).
- （ˇ）Create server.
- （ˇ）Deploy into server
- （ˇ）Combine with frontend interface.
- （ˇ）**Upgrade(web security)** - Check Email
- （ ）**Upgrade(web security)** - Disallow auto-sign-robot.(reCAPTCHA、限制請求次數)
- （ ）**Upgrade(function)** - Real-time update in frontend(Pushing notification in backend)

##### 預計時程
- 11/30 : 完成 laravel 線上課程 -> maybe ~ 12/2。
- 12/03 : 完成 coding env、db Structure
- 12/10 : 完成 規格 1、2、3、4、5、6
- 12/13 : 完成 規格 7、8
- 12/15 : 實作 Nice to have & degub & try

### 實作問題區
1. Laravel Ajax 500 Internal Server error:
[目前查到相關解答，但都試過了還是無效...還在找原因 QAQ)](https://abbasharoon.me/how-to-fix-laravel-ajax-500-internal-server-error/)
最後發現是 $request error ><

2. fetch Post & Put & Delete 問題 (Get 卻沒問題＠＠):
懷疑跟 laravel 安全性，cookies 有關。
最後在 init 加上 `credentials: 'include'` 就可以了。

3. session & token & confirmation_code
這三個是在設計後端跟接資料的時候做的最麻煩的地方，
一直在思考應該怎麼樣接可比較隱密又好，了解一般流程之後
試著自己實做幾次，最後終於做出來。

4. mail server
問題出自於，一開始寄信都可以很順。直到我開始測試寄給不是我自己以外的人之後，我發現就無法寄信了。
最後原來是我使用的 mail server 只是測試帳號 for free，所以只能寄給自己。
於是我用我的 domain 去申請驗證。（還在等待）

5. http->https 問題
不知道為什麼始終吃不到 env('REDIRECT_HTTPS') 這個變數。
一度想要每個都加上 secure_asset(...)
可是又發現 url(...) 也有這個問題。

最後終於找到在 local 端讓他讀 .env 檔案判斷環境，
在 remote 端，使用 default 給他，使他判斷讀取 https。

---

### 簡介
實作 To-do-list application api backend

### 規格
1. 需包含基本功能（CRUD）
2. 系統要可以紀錄待辦事項的內容以及是否完成
3. 可多使用者使用這個平台
4. 需要有使用者註冊功能
5. 使用者需登入才能使用此平台
6. 使用者之間看不到彼此的待辦事項
7. 需要架設伺服器，讓我可以從一個網址直接使用此系統
8. 要整合前端介面
9. 有安全漏洞不太好，請盡量避免

### Nice to have
1. 註冊時檢查 email 所有權（例如寄出認證信）
2. 實作後端推播功能，當兩個瀏覽器頁面同時開啟時，頁面1更新狀態，頁面2也要同步更新
3. 實作防註冊機器人功能，例如 reCAPTCHA、限制請求次數...皆可


## API doc

#### Read 取得清單
- Endpoint
    - https://todoyo.herokuapp.com/{username}/tasks/read
- Method
    - get
- Parameters
    - none

#### Create 新增任務
- Endpoint
    - https://todoyo.herokuapp.com/{username}/tasks/
- Method
    - post
- Parameters
    - content: 字串

#### Update 修改任務
- Endpoint
    - https://todoyo.herokuapp.com/{username}/tasks/{taskId}
- Method
    - put
- Parameters
    - content: 字串，不接受空字串
    - is_done: 布林，僅接受 1, 0, true, false 

#### Delete 刪除任務
- Endpoint
    - https://todoyo.herokuapp.com/{username}/tasks/{taskId}
- Method
    - delete
- Parameters
    - none

