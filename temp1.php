<!DOCTYPE html>
<body>
  <textarea id="code" rows="20">#include <stdio.h>...</textarea>
  <button onclick="compile()">Run</button>
  <div id="output"></div>
  <!-- 加载Emscripten运行时 -->
  <script src="emscripten.js"></script>
  <script>
    async function compile() {
      const code = document.getElementById('code').value;
      const { wasmModule } = await fetch('/compile', {
        method: 'POST', body: code
      });
      // 初始化Module并捕获输出
      Module = {
        print: text => document.getElementById('output').innerHTML += text,
        onRuntimeInitialized: () => Module._main()
      };
      loadWebAssembly(wasmModule);  // 载入编译后的WASM
    }
  </script>
</body>
