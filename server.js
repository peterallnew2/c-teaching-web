// 1. 引入所有必要的套件，包含 cors
const express = require('express');
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');
const cors = require('cors'); // <--- 引入 cors

const app = express();
const PORT = 3000;

// 2. 將所有中介軟體 (Middleware) 集中在最前面，並確保順序正確
app.use(cors()); // <-- 解決 405 Method Not Allowed 錯誤的關鍵！
app.use(express.json()); // 用於解析 application/json
app.use(express.urlencoded({ extended: true })); // 用於解析 application/x-www-form-urlencoded
app.use(express.static('public')); // 提供靜態檔案服務 (如果有的話)


// 3. 只保留一個 app.post('/compile', ...) 定義
app.post('/compile', (req, res) => {
    // 注意：前端傳送的是 application/x-www-form-urlencoded，所以程式碼在 req.body.code
    const source = req.body.code;
    if (!source) {
        return res.status(400).json({ error: 'No code provided in the request body.' });
    }

    const id = Math.random().toString(36).substring(2, 10);
    const tempDir = path.join('/tmp', `c-sandbox-${id}`);
    fs.mkdirSync(tempDir, { recursive: true });

    const sourceFile = path.join(tempDir, 'main.c');
    fs.writeFileSync(sourceFile, source);

    try {
        // 使用 Docker 容器來編譯，這是安全的好作法
        // 您的編譯指令看起來是正確的
        execSync(
            `docker run --rm -v ${tempDir}:/src emcc-sandbox emcc /src/main.c -s WASM=1 -s EXPORTED_RUNTIME_METHODS="['callMain']" -o /src/main.js`,
            { timeout: 15000 } // 設定 15 秒超時
        );

        // 讀取編譯後的檔案
        const mainJs = fs.readFileSync(path.join(tempDir, 'main.js'), 'utf-8');
        const mainWasm = fs.readFileSync(path.join(tempDir, 'main.wasm'));

        // 將檔案內容轉為 Base64 並以 JSON 格式回傳
        res.json({
            js: Buffer.from(mainJs).toString('base64'),
            wasm: Buffer.from(mainWasm).toString('base64'),
        });

    } catch (err) {
        // 4. 改善錯誤回報：如果編譯失敗，將詳細的錯誤訊息回傳給前端
        console.error('Compile error:', err);
        // err.stderr 包含了編譯器(emcc)輸出的錯誤訊息，對除錯非常有幫助
        const errorMessage = err.stderr ? err.stderr.toString() : err.message;
        res.status(500).send(errorMessage); // 直接傳送純文字錯誤

    } finally {
        // 無論成功或失敗，最後都清理暫存目錄
        fs.rmSync(tempDir, { recursive: true, force: true });
    }
});


// 5. 監聽指定的 PORT
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
    console.log('CORS-enabled for all origins.');
});
