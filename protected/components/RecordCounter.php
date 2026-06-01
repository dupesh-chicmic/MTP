<?php
class RecordCounter extends CApplicationComponent
{
    public function storeCounter($data = [], $event)
    {
        // $apicalls = new ApiCalls();
        $connection=Yii::app()->db;
        $sql="INSERT INTO api_calls ( action, parsed_time, reg_number, username, user_kms, passwordText, nonce, created, full_call, result) VALUES( :action, :parsed_time, :reg_number, :username, :user_kms, :passwordText, :nonce, :created, :full_call, :result)";
        $command=$connection->createCommand($sql);
        // replace the placeholder ":username" with the actual username value
        $action = isset($data['action'])?$data['action']:NULL;
        $parsed_time = isset($data['parsed_time'])?$data['parsed_time']:NULL;
        $reg_number = isset($data['reg_number'])?$data['reg_number']:NULL;
        $username = isset($data['username'])?$data['username']:NULL;
        $user_kms = isset($data['user_kms'])?$data['user_kms']:NULL;
        $passwordText = isset($data['passwordText'])?$data['passwordText']:NULL;
        $nonce = isset($data['nonce'])?$data['nonce']:NULL;
        $created = isset($data['created'])?$data['created']:NULL;
        $full_call = isset($data['full_call'])?$data['full_call']:NULL;
        $result = isset($data['result'])?$data['result']:NULL;

        $command->bindParam(":action",$action);
        $command->bindParam(":parsed_time",$parsed_time);
        $command->bindParam(":reg_number",$reg_number);
        $command->bindParam(":username",$username);
        $command->bindParam(":user_kms",$user_kms);
        $command->bindParam(":passwordText",$passwordText);
        $command->bindParam(":nonce",$nonce);
        $command->bindParam(":created",$created);
        $command->bindParam(":full_call",$full_call);
        $command->bindParam(":result",$result);
        // replace the placeholder ":email" with the actual email value
        $ret = $command->execute();
        // echo "<pre>";
        // var_dump($ret);
        // print_r($event);
        // die;
        file_put_contents('./protected/runtime/API_CEMAC_log.log', "\r\n".'(Date:'.date('Y:m:d H:i:sA').' || username:'.$username.' || reg_number:'.$reg_number.' || action:'.$action.')', FILE_APPEND);
        if($ret == 1){
            return true;
        }else {
            return '';
        }
    }
}