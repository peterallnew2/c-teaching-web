import { useState } from 'react'
import { Button } from '@/components/ui/button.jsx'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card.jsx'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs.jsx'
import { Badge } from '@/components/ui/badge.jsx'
import { Progress } from '@/components/ui/progress.jsx'
import { BookOpen, Code, Brain, CheckCircle, ArrowRight, Play, RotateCcw, AlertTriangle, Lightbulb } from 'lucide-react'
import { motion } from 'framer-motion'
import './App.css'

// 完整的題目資料庫
const questions = [
  {
    id: 1,
    question: "若 A[ ][ ]是一個 MxN 的整數陣列，右側程式片段用以計算 A 陣列每一列的總和，以下敘述何者正確？",
    code: `void main() {
    int rowsum = 0;
    for (int i=0; i<M; i=i+1) { 
        for (int j=0; j<N; j-j+1) {
            rowsum = rowsum + A[i][j];
        }
        printf("The sum of row %d is %d.\\n", i, rowsum);
    }
}`,
    options: [
      "第一列總和是正確，但其他列總和不一定正確",
      "程式片段在執行時，會產生錯誤(run-time error)",
      "程式片段中，有語法上的錯誤",
      "程式片段會完成執行並正確印出每一列的總和"
    ],
    correct: 0,
    explanation: {
      analysis: "程式碼分析：外層迴圈 for (int i=0; i<M; i=i+1) 正確，用於遍歷每一列。但內層迴圈 for (int j=0; j<N; j-j+1) 有問題！",
      error: "j-j+1 這個表達式永遠等於 1，這意味著 j 永遠被設為 1，而不是遞增。內層迴圈會變成無窮迴圈，因為 j 永遠不會達到 N。",
      result: "第一列（i=0）會正確計算，但會陷入無窮迴圈，其他列永遠不會執行到。因此第一列總和是正確的，但其他列總和不會被計算。",
      correct: "正確寫法應該是：j=j+1 或 j++"
    }
  },
  {
    id: 2,
    question: "寫出以下程式執行後之輸出結果：",
    code: `#include <stdio.h>
main ()
{
    int i=0,n=0,sum=0,arr[4]={10,15,82,174};
    while (n>=0)
    {
        n=arr[i++];
        if (n>=100) return n ; 
        if (n>=50)
        {
            sum=sum+1000; 
            break;
        }
        if (n>=30) continue; 
        sum=sum+n;
    }
    printf("The sum is %d \\n",sum);
}`,
    options: ["1025", "1010", "1015", "1174"],
    correct: 0,
    explanation: {
      analysis: "變數初始化：i=0, n=0, sum=0, arr[4]={10,15,82,174}",
      steps: [
        "第一次迴圈：n=arr[0]=10, i變成1。10<100, 10<50, 10<30，所以 sum=0+10=10",
        "第二次迴圈：n=arr[1]=15, i變成2。15<100, 15<50, 15<30，所以 sum=10+15=25", 
        "第三次迴圈：n=arr[2]=82, i變成3。82<100, 82>=50，所以 sum=25+1000=1025，然後 break"
      ],
      result: "輸出結果：The sum is 1025"
    }
  },
  {
    id: 3,
    question: "要將陣列 pin[ ]的第 13 個元素的值指定為 100，下列哪一行敘述正確？",
    options: ["pin[12]=100;", "pin[13]=100;", "pin[14]=100;", "pin[15]=100;"],
    correct: 0,
    explanation: {
      concept: "C 語言陣列索引從 0 開始計算",
      mapping: "第 1 個元素：pin[0]，第 2 個元素：pin[1]，第 n 個元素：pin[n-1]",
      calculation: "第 13 個元素的索引 = 13 - 1 = 12，因此是 pin[12]",
      memory: "元素順序：1  2  3  ...  13  ...\n陣列索引：[0][1][2] ... [12] ...",
      note: "常見錯誤：初學者容易直接使用元素順序作為索引。必須記住：元素順序 = 索引 + 1"
    }
  },
  {
    id: 4,
    question: "宣告一個陣列 Y[5]，其索引值最小為？",
    options: ["-1", "1", "0", "5"],
    correct: 2,
    explanation: {
      rule: "C 語言陣列索引規則：所有陣列的索引都從 0 開始，這是 C 語言的基本特性",
      range: "陣列 Y[5] 的索引範圍：最小索引：0，最大索引：4，總共 5 個元素：Y[0], Y[1], Y[2], Y[3], Y[4]",
      difference: "與其他語言的差異：某些語言（如 MATLAB）陣列索引從 1 開始，但 C 語言始終從 0 開始",
      memory: "記憶體角度：陣列名稱代表起始位址，索引 0 表示相對於起始位址的偏移量為 0"
    }
  },
  {
    id: 5,
    question: "宣告一個 4 列 5 行的二維陣列，則此陣列的元素個數有幾個？",
    options: ["30", "20", "50", "60"],
    correct: 1,
    explanation: {
      formula: "二維陣列元素計算：元素總數 = 列數 × 行數 = 4 × 5 = 20 個元素",
      declaration: "二維陣列宣告：int arr[4][5]; // 4 列 5 行",
      layout: `元素分布：
arr[0][0] arr[0][1] arr[0][2] arr[0][3] arr[0][4]  // 第1列
arr[1][0] arr[1][1] arr[1][2] arr[1][3] arr[1][4]  // 第2列  
arr[2][0] arr[2][1] arr[2][2] arr[2][3] arr[2][4]  // 第3列
arr[3][0] arr[3][1] arr[3][2] arr[3][3] arr[3][4]  // 第4列`,
      memory: "記憶體佔用：如果是 int 型別（4 bytes），總記憶體 = 20 × 4 = 80 bytes"
    }
  },
  {
    id: 6,
    question: "下列這段程式碼片段的描述，何者錯誤？",
    code: `int k=10; 
int *p;
*p=100;`,
    options: [
      "宣告一個整數變數 k，同時給定初始值為 10",
      "宣告一個指標變數 p",
      "指標變數所指向的記憶體位置，存放的值是 100",
      "指標變數 p 有指向確切的記憶體位址"
    ],
    correct: 3,
    explanation: {
      analysis: "程式碼分析：int k=10; ✓ 正確宣告整數變數 k 並初始化為 10；int *p; ✓ 正確宣告指標變數 p；*p=100; ⚠️ 危險操作！",
      error: "錯誤分析：指標 p 被宣告但未初始化，p 包含隨機的記憶體位址（垃圾值），*p=100 嘗試在未知位址寫入值 100",
      problems: "潛在問題：記憶體存取違規（可能存取到不屬於程式的記憶體）、程式崩潰（可能導致 Segmentation Fault）、未定義行為（結果不可預測）",
      correct: `正確寫法：
int k=10;
int *p = &k;  // 讓 p 指向 k 的位址
*p=100;       // 現在安全了`
    }
  },
  {
    id: 7,
    question: "有關 C 語言中陣列的描述，下列何者錯誤？",
    options: [
      "陣列是一種資料結構",
      "陣列的索引值最小為 1", 
      "陣列會佔用記憶體連續的空間",
      "陣列名稱為第 1 個元素的位址"
    ],
    correct: 1,
    explanation: {
      analysis: "(A) ✓ 正確：陣列確實是一種資料結構，用於存儲相同類型的多個元素；(B) ✗ 錯誤：C 語言陣列索引從 0 開始，不是從 1 開始；(C) ✓ 正確：陣列元素在記憶體中連續存放；(D) ✓ 正確：陣列名稱等同於第一個元素（索引 0）的位址",
      index: "陣列索引詳解：int arr[5] = {10, 20, 30, 40, 50};\n// 索引：    0   1   2   3   4\n// 最小索引是 0，不是 1",
      memory: "記憶體連續性：\n記憶體位址： 0x1000  0x1004  0x1008  0x100C  0x1010\n陣列元素：   arr[0]  arr[1]  arr[2]  arr[3]  arr[4]",
      pointer: "陣列名稱作為指標：int arr[5]; // arr 等同於 &arr[0]，都指向陣列的起始位址"
    }
  },
  {
    id: 8,
    question: "在 C 語言中，指標變數 ptr 指向某一個整數變數，已知該指標的值為 0x1234，則 ptr+1 的值為何？",
    options: ["0x1235", "0x1236", "0x1237", "0x1238"],
    correct: 3,
    explanation: {
      principle: "指標運算原理：指標運算會自動考慮所指向資料型別的大小，ptr + 1 不是簡單的位址 + 1",
      calculation: "整數指標運算：int 型別通常佔用 4 個位元組，ptr + 1 = ptr + (1 × sizeof(int)) = ptr + 4",
      example: "計算過程：ptr = 0x1234，ptr + 1 = 0x1234 + 4 = 0x1238",
      types: `不同資料型別的指標運算：
char *p1 = (char*)0x1000;    // p1 + 1 = 0x1001 (+ 1 byte)
int *p2 = (int*)0x1000;      // p2 + 1 = 0x1004 (+ 4 bytes)  
double *p3 = (double*)0x1000; // p3 + 1 = 0x1008 (+ 8 bytes)`,
      application: "實際應用：這個特性讓陣列遍歷變得簡單，arr[i] 等同於 *(arr + i)"
    }
  },
  {
    id: 9,
    question: "要循序讀取某陣列的所有元素，最適合使用 C 語言的哪一種結構？",
    options: ["if", "switch", "for", "break"],
    correct: 2,
    explanation: {
      comparison: "迴圈結構比較：for 迴圈最適合已知次數的重複操作；while 迴圈適合條件控制的重複操作；do-while 迴圈適合至少執行一次的重複操作",
      characteristics: "陣列遍歷特性：陣列大小通常已知，需要從索引 0 到 n-1 依序存取，這正是 for 迴圈的強項",
      example: `典型的陣列遍歷：
int arr[10];
for (int i = 0; i < 10; i++) {
    printf("%d ", arr[i]);  // 循序讀取
}`,
      others: "其他選項分析：(A) if：條件判斷，不是迴圈結構；(B) switch：多分支選擇，不適合重複操作；(D) break：跳出語句，不是控制結構",
      advantages: "for 迴圈的優勢：初始化、條件檢查、遞增都在一行；程式碼簡潔易讀；不容易出現無窮迴圈"
    }
  },
  {
    id: 10,
    question: "一個一維陣列 int D[5]={34,21,54,69,2};下列哪一行程式敘述可以取得元素 69？",
    options: ["D[4]", "*(D+3)", "&(D+3)", "*D"],
    correct: 1,
    explanation: {
      array: "陣列內容分析：int D[5] = {34, 21, 54, 69, 2};\n//索引：    0   1   2   3   4\n元素 69 位於索引 3",
      options: "(A) D[4]：取得索引 4 的元素 = 2 ❌；(B) *(D+3)：取得索引 3 的元素 = 69 ✓；(C) &(D+3)：取得索引 3 元素的位址，不是值 ❌；(D) *D：等同於 D[0]，取得索引 0 的元素 = 34 ❌",
      equivalence: "指標與陣列的等價關係：D[3] ≡ *(D+3)  // 兩者完全等價",
      memory: `記憶體視覺化：
位址：   0x1000  0x1004  0x1008  0x100C  0x1010
元素：   D[0]    D[1]    D[2]    D[3]    D[4]
值：     34      21      54      69      2

D+3 指向 0x100C
*(D+3) 取得 0x100C 位址的值 = 69`,
      concept: "重要概念：D 是陣列名稱，代表起始位址；D+3 是位址運算，指向第 4 個元素；*(D+3) 是解參考，取得該位址的值"
    }
  },
  {
    id: 35,
    question: "宣告某陣列 int arr[4]={1,2,3,4}，下列何者的值與 arr[3] 一樣？",
    options: ["*arr", "*(arr+1)", "*(arr+2)", "*(arr+3)"],
    correct: 3,
    explanation: {
      arrayDef: "依陣列解釋 - 變數定義：arr 是陣列名，代表整個陣列的起始地址（即首元素 arr[0] 的地址），它是一個地址常量（不可修改）。例如，若 arr[0] 的地址為 0x1000，則：arr[1] 地址 = 0x1000 + sizeof(int) = 0x1004；arr[2] 地址 = 0x1008；arr[3] 地址 = 0x100C（假設 int 占 4 字節）",
      pointerDef: "依指標解釋 - 指標與地址的關係：arr 是首元素地址（&arr[0]），類型為 int*。arr + n 表示偏移 n 個元素的地址，計算方式為：arr + n = arr + n * sizeof(int)。例如：arr + 0 → 0x1000（指向 arr[0]）；arr + 3 → 0x100C（指向 arr[3]）",
      table: `題目選項解析：等價表示對比
| 選項 | 展開形式 | 地址計算 | 內容（值） | 是否等於 arr[3] |
|------|----------|----------|------------|----------------|
| (A) *arr | *(arr + 0) | 0x1000 | 1 | ❌（arr[0]） |
| (B) *(arr+1) | *(arr + 1) | 0x1004 | 2 | ❌（arr[1]） |
| (C) *(arr+2) | *(arr + 2) | 0x1008 | 3 | ❌（arr[2]） |
| (D) *(arr+3) | *(arr + 3) | 0x100C | 4 | ✅（arr[3]） |`,
      conclusion: "關鍵結論：arr[3] 本質是指標運算的語法糖，編譯器將其轉換為 *(arr + 3)。因此，arr[3] 與 *(arr + 3) 完全等價，均訪問地址 0x100C 的內容 4。"
    }
  }
];

// 記憶體視覺化元件
function MemoryVisualization({ arrayData, pointerIndex }) {
  return (
    <div className="bg-gray-50 p-6 rounded-lg border">
      <h3 className="text-lg font-semibold mb-4 text-blue-900">記憶體布局視覺化</h3>
      <div className="flex flex-col space-y-4">
        {/* 陣列視覺化 */}
        <div className="flex items-center space-x-2">
          <span className="text-sm font-medium w-16">陣列:</span>
          <div className="flex border border-gray-300 rounded">
            {arrayData.map((value, index) => (
              <div
                key={index}
                className={`w-16 h-16 flex flex-col items-center justify-center border-r border-gray-300 last:border-r-0 ${
                  index === pointerIndex ? 'bg-orange-100 border-orange-300' : 'bg-white'
                }`}
              >
                <div className="text-xs text-gray-500">arr[{index}]</div>
                <div className="text-lg font-bold">{value}</div>
              </div>
            ))}
          </div>
        </div>
        
        {/* 記憶體位址 */}
        <div className="flex items-center space-x-2">
          <span className="text-sm font-medium w-16">位址:</span>
          <div className="flex">
            {arrayData.map((_, index) => (
              <div key={index} className="w-16 text-center text-xs text-gray-600">
                0x{(4096 + index * 4).toString(16).toUpperCase()}
              </div>
            ))}
          </div>
        </div>
        
        {/* 指標視覺化 */}
        {pointerIndex !== null && (
          <div className="flex items-center space-x-2">
            <span className="text-sm font-medium w-16">指標:</span>
            <div className="flex items-center">
              <div className="text-orange-600 font-bold mr-2">*ptr</div>
              <ArrowRight className="text-orange-600 w-4 h-4" />
              <div className="ml-2 text-sm">
                指向 arr[{pointerIndex}] (值: {arrayData[pointerIndex]})
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}

// 程式碼編輯器元件
function CodeEditor({ code, onChange }) {
  return (
    <div className="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm">
      <div className="flex items-center justify-between mb-2">
        <span className="text-gray-400">C 程式碼</span>
        <div className="flex space-x-2">
          <Button size="sm" variant="outline" className="text-xs">
            <Play className="w-3 h-3 mr-1" />
            執行
          </Button>
          <Button size="sm" variant="outline" className="text-xs">
            <RotateCcw className="w-3 h-3 mr-1" />
            重設
          </Button>
        </div>
      </div>
      <textarea
        value={code}
        onChange={(e) => onChange(e.target.value)}
        className="w-full h-32 bg-transparent border border-gray-700 rounded p-2 resize-none focus:outline-none focus:border-green-400"
        placeholder="在此輸入 C 程式碼..."
      />
    </div>
  );
}

// 詳細解說元件
function DetailedExplanation({ explanation, questionId }) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      className="bg-blue-50 p-6 rounded-lg border border-blue-200 space-y-4"
    >
      <div className="flex items-center mb-4">
        <Lightbulb className="w-5 h-5 text-blue-600 mr-2" />
        <h4 className="font-semibold text-blue-900">詳細解答說明</h4>
      </div>
      
      {explanation.analysis && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">📋 程式碼分析：</h5>
          <p className="text-blue-700 text-sm">{explanation.analysis}</p>
        </div>
      )}
      
      {explanation.error && (
        <div>
          <h5 className="font-medium text-red-800 mb-2">⚠️ 錯誤分析：</h5>
          <p className="text-red-700 text-sm">{explanation.error}</p>
        </div>
      )}
      
      {explanation.steps && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">🔄 執行步驟：</h5>
          <ol className="list-decimal list-inside text-blue-700 text-sm space-y-1">
            {explanation.steps.map((step, index) => (
              <li key={index}>{step}</li>
            ))}
          </ol>
        </div>
      )}
      
      {explanation.concept && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">💡 重要概念：</h5>
          <p className="text-blue-700 text-sm">{explanation.concept}</p>
        </div>
      )}
      
      {explanation.mapping && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">🗺️ 索引對應：</h5>
          <p className="text-blue-700 text-sm">{explanation.mapping}</p>
        </div>
      )}
      
      {explanation.calculation && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">🧮 計算過程：</h5>
          <p className="text-blue-700 text-sm">{explanation.calculation}</p>
        </div>
      )}
      
      {explanation.memory && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">🧠 記憶體視覺化：</h5>
          <pre className="text-blue-700 text-xs bg-blue-100 p-2 rounded overflow-x-auto">{explanation.memory}</pre>
        </div>
      )}
      
      {explanation.table && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">📊 選項對比表：</h5>
          <pre className="text-blue-700 text-xs bg-blue-100 p-2 rounded overflow-x-auto">{explanation.table}</pre>
        </div>
      )}
      
      {explanation.arrayDef && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">📚 陣列定義：</h5>
          <p className="text-blue-700 text-sm">{explanation.arrayDef}</p>
        </div>
      )}
      
      {explanation.pointerDef && (
        <div>
          <h5 className="font-medium text-blue-800 mb-2">👉 指標定義：</h5>
          <p className="text-blue-700 text-sm">{explanation.pointerDef}</p>
        </div>
      )}
      
      {explanation.conclusion && (
        <div>
          <h5 className="font-medium text-green-800 mb-2">🎯 關鍵結論：</h5>
          <p className="text-green-700 text-sm font-medium">{explanation.conclusion}</p>
        </div>
      )}
      
      {explanation.result && (
        <div>
          <h5 className="font-medium text-green-800 mb-2">✅ 執行結果：</h5>
          <p className="text-green-700 text-sm font-medium">{explanation.result}</p>
        </div>
      )}
      
      {explanation.correct && (
        <div>
          <h5 className="font-medium text-green-800 mb-2">✏️ 正確寫法：</h5>
          <pre className="text-green-700 text-sm bg-green-100 p-2 rounded">{explanation.correct}</pre>
        </div>
      )}
    </motion.div>
  );
}

// 題目練習元件
function QuizSection() {
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [selectedAnswer, setSelectedAnswer] = useState(null);
  const [showExplanation, setShowExplanation] = useState(false);
  const [score, setScore] = useState(0);
  const [completed, setCompleted] = useState([]);

  const handleAnswer = (answerIndex) => {
    setSelectedAnswer(answerIndex);
    setShowExplanation(true);
    
    if (answerIndex === questions[currentQuestion].correct) {
      setScore(score + 1);
      if (!completed.includes(currentQuestion)) {
        setCompleted([...completed, currentQuestion]);
      }
    }
  };

  const nextQuestion = () => {
    setSelectedAnswer(null);
    setShowExplanation(false);
    setCurrentQuestion((prev) => (prev + 1) % questions.length);
  };

  const prevQuestion = () => {
    setSelectedAnswer(null);
    setShowExplanation(false);
    setCurrentQuestion((prev) => (prev - 1 + questions.length) % questions.length);
  };

  const question = questions[currentQuestion];

  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <div className="flex justify-between items-center">
            <CardTitle>題目練習</CardTitle>
            <Badge variant="secondary">
              {currentQuestion + 1} / {questions.length}
            </Badge>
          </div>
          <Progress value={(completed.length / questions.length) * 100} className="w-full" />
          <div className="text-sm text-gray-600">
            已完成：{completed.length} 題，正確率：{completed.length > 0 ? Math.round((score / completed.length) * 100) : 0}%
          </div>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div>
              <h3 className="text-lg font-medium mb-3">題目 {question.id}：{question.question}</h3>
              
              {question.code && (
                <div className="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm mb-4">
                  <div className="text-gray-400 mb-2">程式碼：</div>
                  <pre className="whitespace-pre-wrap">{question.code}</pre>
                </div>
              )}
            </div>
            
            <div className="grid grid-cols-1 gap-2">
              {question.options.map((option, index) => (
                <Button
                  key={index}
                  variant={
                    selectedAnswer === index
                      ? index === question.correct
                        ? "default"
                        : "destructive"
                      : "outline"
                  }
                  className="justify-start text-left h-auto p-3"
                  onClick={() => handleAnswer(index)}
                  disabled={showExplanation}
                >
                  <span className="mr-2">({String.fromCharCode(65 + index)})</span>
                  {option}
                  {showExplanation && index === question.correct && (
                    <CheckCircle className="ml-auto w-4 h-4" />
                  )}
                </Button>
              ))}
            </div>
            
            {showExplanation && (
              <DetailedExplanation 
                explanation={question.explanation} 
                questionId={question.id}
              />
            )}
            
            <div className="flex justify-between pt-4">
              <Button 
                onClick={prevQuestion} 
                variant="outline"
                disabled={currentQuestion === 0}
              >
                上一題
              </Button>
              <Button onClick={nextQuestion}>
                下一題 <ArrowRight className="ml-2 w-4 h-4" />
              </Button>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}

function App() {
  const [arrayData, setArrayData] = useState([1, 2, 3, 4]);
  const [pointerIndex, setPointerIndex] = useState(0);
  const [code, setCode] = useState(`#include <stdio.h>

int main() {
    int arr[4] = {1, 2, 3, 4};
    int *ptr = &arr[0];
    
    printf("arr[3] = %d\\n", arr[3]);
    printf("*(arr+3) = %d\\n", *(arr+3));
    
    return 0;
}`);

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
      {/* 導航列 */}
      <nav className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              <BookOpen className="h-8 w-8 text-blue-600 mr-3" />
              <h1 className="text-xl font-bold text-gray-900">C 語言陣列與指標互動式教學</h1>
            </div>
          </div>
        </div>
      </nav>

      {/* 主要內容 */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* 歡迎區域 */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="text-center mb-12"
        >
          <h2 className="text-4xl font-bold text-gray-900 mb-4">
            掌握 C 語言陣列與指標
          </h2>
          <p className="text-xl text-gray-600 mb-8">
            透過互動式視覺化學習，深入理解記憶體操作的核心概念
          </p>
          <div className="flex justify-center space-x-6">
            <div className="flex items-center">
              <Code className="h-5 w-5 text-blue-600 mr-2" />
              <span className="text-gray-700">程式碼實作</span>
            </div>
            <div className="flex items-center">
              <Brain className="h-5 w-5 text-green-600 mr-2" />
              <span className="text-gray-700">視覺化學習</span>
            </div>
            <div className="flex items-center">
              <CheckCircle className="h-5 w-5 text-orange-600 mr-2" />
              <span className="text-gray-700">詳細解說</span>
            </div>
          </div>
        </motion.div>

        {/* 主要學習區域 */}
        <Tabs defaultValue="concept" className="space-y-6">
          <TabsList className="grid w-full grid-cols-3">
            <TabsTrigger value="concept">概念學習</TabsTrigger>
            <TabsTrigger value="practice">程式實作</TabsTrigger>
            <TabsTrigger value="quiz">題目練習</TabsTrigger>
          </TabsList>

          <TabsContent value="concept" className="space-y-6">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <Card>
                <CardHeader>
                  <CardTitle>陣列與指標的關係</CardTitle>
                  <CardDescription>
                    理解陣列名稱如何作為指標使用
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <p className="text-gray-700">
                      在 C 語言中，陣列名稱本身就是一個指向陣列第一個元素的指標。
                      當我們宣告 <code className="bg-gray-100 px-1 rounded">int arr[4]</code> 時，
                      <code className="bg-gray-100 px-1 rounded">arr</code> 實際上等同於 
                      <code className="bg-gray-100 px-1 rounded">&arr[0]</code>。
                    </p>
                    <div className="bg-blue-50 p-4 rounded-lg">
                      <h4 className="font-semibold text-blue-900 mb-2">重要概念：</h4>
                      <ul className="list-disc list-inside text-blue-800 space-y-1">
                        <li>arr[i] 等同於 *(arr + i)</li>
                        <li>指標運算會自動考慮資料型別大小</li>
                        <li>陣列索引從 0 開始</li>
                      </ul>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <Card>
                <CardHeader>
                  <CardTitle>記憶體位址計算</CardTitle>
                  <CardDescription>
                    學習如何計算陣列元素的記憶體位址
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <p className="text-gray-700">
                      假設 <code className="bg-gray-100 px-1 rounded">int arr[4]</code> 的起始位址為 0x1000，
                      由於 int 佔用 4 個位元組，各元素位址為：
                    </p>
                    <div className="bg-gray-50 p-4 rounded-lg font-mono text-sm">
                      <div>arr[0]: 0x1000 (值: 1)</div>
                      <div>arr[1]: 0x1004 (值: 2)</div>
                      <div>arr[2]: 0x1008 (值: 3)</div>
                      <div>arr[3]: 0x100C (值: 4)</div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            <MemoryVisualization arrayData={arrayData} pointerIndex={pointerIndex} />

            <Card>
              <CardHeader>
                <CardTitle>互動式指標操作</CardTitle>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  <p className="text-gray-700">點擊下方按鈕來移動指標，觀察記憶體視覺化的變化：</p>
                  <div className="flex space-x-2">
                    {arrayData.map((_, index) => (
                      <Button
                        key={index}
                        variant={pointerIndex === index ? "default" : "outline"}
                        onClick={() => setPointerIndex(index)}
                      >
                        指向 arr[{index}]
                      </Button>
                    ))}
                  </div>
                </div>
              </CardContent>
            </Card>
          </TabsContent>

          <TabsContent value="practice" className="space-y-6">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <Card>
                <CardHeader>
                  <CardTitle>程式碼編輯器</CardTitle>
                  <CardDescription>
                    在此編寫和測試 C 程式碼
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <CodeEditor code={code} onChange={setCode} />
                </CardContent>
              </Card>

              <Card>
                <CardHeader>
                  <CardTitle>執行結果</CardTitle>
                  <CardDescription>
                    程式執行的輸出結果
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm min-h-32">
                    <div className="text-gray-400 mb-2">輸出：</div>
                    <div>arr[3] = 4</div>
                    <div>*(arr+3) = 4</div>
                  </div>
                </CardContent>
              </Card>
            </div>

            <MemoryVisualization arrayData={arrayData} pointerIndex={pointerIndex} />
          </TabsContent>

          <TabsContent value="quiz" className="space-y-6">
            <QuizSection />
          </TabsContent>
        </Tabs>
      </main>

      {/* 頁尾 */}
      <footer className="bg-white border-t mt-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center text-gray-600">
            <p>© 2025 C 語言陣列與指標互動式教學. 專為程式設計學習者設計.</p>
            <p className="text-sm mt-2">包含 {questions.length} 道精選題目與詳細解說</p>
          </div>
        </div>
      </footer>
    </div>
  )
}

export default App

