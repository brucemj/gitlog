<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$columns = "ch, phl, phr, subject, author, authorDate, committer, commitDate";
		// read commits from database;
		$ci = M('table_minlog')->field($columns)->select();
		
		$kv = array();  // create new key-value array using the data from databases;
		$result = array(); // sort commits by HEAD -> parent;
		$rootCi = "4f1c35c"; // example  root commit;
		foreach ($ci as $v){
			$kv[ $v[ch] ] = $v;
		}
		
		$res = gitlg($kv);
		
		
		p($res);
		die;
		$this->result = $result;
		$this->display();
    }
}