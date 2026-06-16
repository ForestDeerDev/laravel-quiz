<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // (1) 定义试题数据
    static $questions = array(
        array("10+4=?", "12", "14", "16", "B"),
        array("20-9=?", "7", "13", "11", "C"),
        array("7x3=?", "21", "24", "25", "A"),
        array("8/2=?", "10", "2", "4", "C"),
    );

    // (2) 定义 Session 属性名常量
    const PARAM_ANSWERS = "answers";

    // (3) 获取题目内容
    private function getQuestion($qid)
    {
        $question = self::$questions[$qid];
        $options = array();
        for ($i = 1; $i < 4; $i++) {
            $val = chr(ord("A") + $i - 1);
            $options[$val] = $val . "." . $question[$i];
        }
        return array(
            "qid" => $qid + 1,
            "stem" => $question[0],
            "options" => $options,
            "last" => (count(self::$questions) == $qid + 1) ? true : false
        );
    }

    // (4) start() 显示第一题并初始化 session
    public function start(Request $request)
    {
        $question = $this->getQuestion(0);
        $request->session()->forget(self::PARAM_ANSWERS);
        $request->session()->put(self::PARAM_ANSWERS, array());
        return view("quiz", $question);
    }

    // (5) next() 保存上一题答案并显示下一题
    public function next(Request $request, $qid)
    {
        // 获取上一题用户的选择
        $choice = $request->input("choices");
        // 将用户的答案保存到 Session
        $answers = $request->session()->get(self::PARAM_ANSWERS);
        array_push($answers, $choice);
        $request->session()->put(self::PARAM_ANSWERS, $answers);
        // 获取下一题内容
        $question = $this->getQuestion($qid);
        return view("quiz", $question);
    }

    // (6) submit() 计算分数并显示结果
    public function submit(Request $request)
    {
        // 取出前面所有答案并清空 session
        $answers = $request->session()->get(self::PARAM_ANSWERS);
        $request->session()->forget(self::PARAM_ANSWERS);
        // 获取最后一题答案
        $choice = $request->input("choices");
        array_push($answers, $choice);

        // 计算正确题数
        $question_count = count(self::$questions);
        $right_num = 0;
        for ($i = 0; $i < $question_count; $i++) {
            if ($answers[$i] == self::$questions[$i][4]) {
                $right_num++;
            }
        }
        $score = 100 * ($right_num / $question_count);

        // 返回结果页面
        return view("result", ["score" => $score, "right_num" => $right_num]);
    }
}