<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Response;

trait APIResponser {

    public function respondCollection($message, $data) {
        return response()->json([
                    'code' => Response::HTTP_OK,
                    'message' => $message,
                    'data' => $data,
                        ], 201);
    }
    public function respondReferalCollection($message, $data,$referralCompany) {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'referral_company_loan_type' => [$referralCompany],
        ], 201);
    }
    protected function respondPermissionDenied() {
        return response()->json([
                    'code' => 403,
                    'message' => 'Permission denied',
                        ], 200);
    }

    protected function exceptionResponse($msg, $code,$responseCode = 200) {
        $result = [
            'code' => $code,
            'message' => $msg,
        ];

        return response()->json($result, $responseCode);
    }

    protected function clientOutOfDateResponse() {
        $result = [
            'code' => 426,
            'message' => 'ချေးငွေလျှောက်ထားသူတွေ အသုံးပြုရတာ ပိုမို အဆင်ပြေနိုင်စေဖို့ Application Version အသစ်တစ်ခု ထပ်မံ release ပြုလုပ်ထားပါတယ် ။ Version အသစ်ကို Mother Finance Website ဒါမှမဟုတ် Google Play ကနေ download ဆွဲ update ပြုလုပ်ပြီး Mother Finance ရဲ့ ချေးငွေ ဝန်ဆောင်မှုများကို ဆက်လက်အသုံးပြုနိုင်မှာ ဖြစ်ပါတယ် ။',
        ];

        return response()->json($result, 200);
    }

    protected function clientOutOfDateForceResponse() {
        $result = [
            'code' => 426,
            'message' => 'ချေးငွေလျှောက်ထားသူတွေ အသုံးပြုရတာ ပိုမို အဆင်ပြေနိုင်စေဖို့ Application Version အသစ်တစ်ခု ထပ်မံ release ပြုလုပ်ထားပါတယ် ။ Version အသစ်ကို Mother Finance Website ဒါမှမဟုတ် Google Play ကနေ download ဆွဲ update ပြုလုပ်ပြီး Mother Finance ရဲ့ ချေးငွေ ဝန်ဆောင်မှုများကို ဆက်လက်အသုံးပြုနိုင်မှာ ဖြစ်ပါတယ် ။',
        ];

        return response()->json($result, 422);
    }

    protected function errorResponse($msg) {
        $result = [
            'code' => 426,
            'message' => $msg,
        ];

        return response()->json($result, 200);
    }


    public function respondSuccessMsgOnly($message) {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
        ], 200);
    }
    public function respondImage($message,$imagePath) {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'url' => $imagePath,
        ], 201);
    }
    public function respondImageMicroLoan($message,$imagePath) {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $imagePath
        ], 201);
    }

    protected function exceptionResponseGuarantorValid($msg, $code,$statusFlag) {
        $result = [
            'code' => $code,
            'guarantorInvalid' => $statusFlag,
            'message' => $msg,
        ];

        return response()->json($result, 200);
    }
    protected function responseMicroLoanRequestEligible($msg, $code,$statusFlag,$loanType=null,$loanCount=0) {
        if ($loanType === null) {
            $result = [
                'code' => $code,
                'is_eligible' => $statusFlag,
                'closeMicroLoanCount' => $loanCount,
                'message' => $msg,
            ];
        } else {
            $result = [
                'code' => $code,
                'is_eligible' => $statusFlag,
                'closeMicroLoanCount' => $loanCount,
                'message' => $msg,
                'data' => $loanType
            ];
        }

        return response()->json($result, 200);
    }
    protected function newResponseMicroLoanRequestEligible($msg, $code,$data) {
        $result = [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];
        return response()->json($result, 200);
    }

    protected function exceptionLoanRequestEligible($msg, $code, $statusFlag) {
            $result = [
                'code' => $code,
                'is_eligible' => $statusFlag,
                'message' => $msg,
            ];


        return response()->json($result, 200);
    }
    protected function responseMicroLoanAnswerSubmit($msg, $code,$answerSubmitID) {
        $result = [
            'code' => $code,
            'message' => $msg,
            'answer_submit_id'=>$answerSubmitID
        ];

        return response()->json($result, 200);
    }
    protected function responseSalaryLoanRequestEligible($msg, $code,$data) {
        $result = [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($result, 200);
    }
    public function respondErrorToken($message)
    {
        return response()->json([
            'status' => 'FAIL',
            'status_code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message,
        ], 400);
    }

}
