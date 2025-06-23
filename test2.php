<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>C Online Sandbox</title>
    <style>
        textarea { width: 100%; height: 200px; }
        pre { background: #eee; padding: 10px; }
    </style>
</head>
<body>
    <h1>Online C Compiler (Emscripten)</h1>
    <textarea id="code">
#include <stdio.h>
int main() {
    printf("Hello, Online Compiler!\\n");
    return 0;
}
    </textarea>
    <br/>
    <button onclick="compileAndRun()">Run</button>
    <h3>Output:</h3>
    <pre id="output"></pre>

    <script src="https://emscripten.org/docs/porting/connecting_cpp_and_javascript/Interacting-with-code.html"></script>
    <!-- 用预先编译好的 Module.js (必须用 emcc 生成) -->
    <script src="a.out.js"></script>
    <script>
        async function compileAndRun() {
            const output = document.getElementById('output');
            output.textContent = 'Running...';

            const code = document.getElementById('code').value;

            // 用 fetch 或 AJAX 向后端发送代码，后端用 emcc 编译再返回 wasm
            // 这里演示：直接使用预编译 wasm，不动态编译（简化示例）

            Module['print'] = text => output.textContent += text + '\n';
            Module['printErr'] = text => output.textContent += 'ERR: ' + text + '\n';

            // 可以用 Module.cwrap 调用导出的 C 函数
            // 本示例是 Hello World，不动态替换
            output.textContent = '示例是固定代码，若要支持用户动态代码，请用后端 emcc 沙箱容器！';
        }
    </script>
</body>
</html>
