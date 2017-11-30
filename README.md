# To-do App

### 更新紀錄
- 11/30 完成 (86/309) 課程，會使用 laravel 實作基本 one/many relationship、CRUD 打算做完這一次的 practice(第 125 節) 後開始實做此專案。預計明天完成。
- 11/25 專案確立、確認規格、時程（12/24 前做完）

### To-do
- （ ）Finish Udemy's laravel online course.
- （ ）Build coding env. 
- （ ）Build/set db structure.
- （ ）Implement CRUD.
- （ ）Implement recording items whether it have done.
- （ ）Implement account system(Log-in / Log-out / Sign-in/).
- （ ）Implement 規格(No.5).
- （ ）Implement 規格(No.6).
- （ ）Create server.
- （ ）Deploy into server
- （ ）Combine with frontend interface.
- （ ）**Upgrade(web security)** - Check Email
- （ ）**Upgrade(web security)** - Disallow auto-sign-robot.(reCAPTCHA、限制請求次數)
- （ ）**Upgrade(function)** - Real-time update in frontend(Pushing notification in backend)

##### 預計時程
- 11/30 : 完成 laravel 線上課程 -> maybe ~ 12/2。
- 12/03 : 完成 coding env、db Structure
- 12/10 : 完成 規格 1、2、3、4、5、6
- 12/13 : 完成 規格 7、8
- 12/15 : 實作 Nice to have & degub & try

### 實作問題區



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
