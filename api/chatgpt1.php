<?php
//请求示例:http://域名/chatgpt_api.php?sys=你是一个无所不知的学者&msg=你是谁
//连续对话就把请求之后，它回复你的内容传参给sys，再继续将问题传参给msg提交请求就行
//例如，它回复：你好，我是一个无所不知的学者
//连续对话就：http://域名/chatgpt_api.php?sys=你好，我是一个无所不知的学者&msg=我知道了
//输出的是json格式的内容，自行解析回复内容
// 定义您的API密钥，模型名称和消息列表
$api_key = "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";
$model = "gpt-3";
$messages = [
  ["role" => "system", "content" => $_GET["sys"]], // 假设用户通过get方法提交了system_input参数
  ["role" => "user", "content" => $_GET["msg"]], // 假设用户通过get方法提交了user_input参数
];

// 将消息列表转换为JSON格式
$data = json_encode(["model" => $model, "messages" => $messages]);

// 创建一个curl句柄
$ch = curl_init();

// 设置curl选项
curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/completions");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $api_key",
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 执行curl请求并获取响应
$response = curl_exec($ch);

// 关闭curl句柄
curl_close($ch);

// 打印响应
echo $response;

?>
