<?php
	function p($array){
		dump($array, 1, '<pre>', 0);
	}
	
		// foreach ($ci as $v){
		// 	$kv[ $v[ch] ] = $v;
		// }

	function gitlg($kv){
		$curCi = "bac84b1"; // example  root commit;
		$result = array(); // sort commits by HEAD -> parent;
		$leftSet = '';		// left line hash set.
		$mergeCI = '';		// the merge commit
		$splitCI = '';		// the split commit
		$splitSt = 0;		// is it still spliting
		$line = '* ';		// the default char graph for line

		while ( $curCi != ''){
			echo $line . $curCi . '<br />' ;
			$result[] = $kv[$curCi];
			
			if( $kv[$curCi][phl] != $kv[$curCi][phr] ){		// is it merge commit ?
				$line = '|\ <br \>';
				$mergeCI = $kv[$curCi][ch];
				$splitSt = 1;
				$phPoint = $kv[$curCi][phl];
				while($phPoint != ''){
					$leftSet = $leftSet . $phPoint .',';
					$phPoint = $kv[$phPoint][phl];
				}
				//echo '$mergeCI==' . $mergeCI  .'<br/>';	
				//echo $leftSet .'<br/>';	
			}else{
				$line = '* ';
			}

			if( $leftSet == ''){	// is there left commit still ?
				$curCi = $kv[$curCi][phl];
				if ($splitCI==$curCi) 
				 	$splitSt = 0;
				switch($splitSt){
					case 0:
						$line = ($splitCI==$curCi) ? ('|/<br />* ') :('* ');
						break;
					case 1:
						$line = ($splitCI==$curCi) ? ('|/<br />* ') :('* | ');
						break;
				}							
			}else{	// is the right commit finishing ?
				$line = ($mergeCI==$curCi) ? ($line . '| * ') : ('| * ') ;
				$curCi = $kv[$curCi][phr];
				
				//echo $leftSet .'----'. $curCi .'<br/>';
				if( substr_count($leftSet, $curCi) ){
					$splitCI = $curCi;
					$line = '* | ';
					$curCi = $kv[$mergeCI][phl];
					$leftSet = '';
				}
			}

		}

		return $result;

	}

	
	static $i=0;
	function preNote($array, $ci){
		
		static $arrText= array();
		 $leftText = '';
		 $rightText = '';
		static $allText = '';
		$curCi = $ci; // example  root commit;
		$kv = $array;
		
		if( $kv[$curCi]['phl'] != $kv[$curCi]['phr']){
			while($kv[$curCi]['phl']){
				if( ! substr_count($allText, $kv[$curCi]['phl'])){
					$allText .= $kv[$curCi]['phl']; $allText .= ',';
					$leftText .= $kv[$curCi]['phl']; $leftText .= ',';
					$curCi = $kv[$curCi]['phl'];
				}
			}
			$arrText[] = array( 'leftText' =>$leftText );

			$curCi = $ci;
			while( $kv[$curCi]['phr'] != ''){

				if( ! substr_count($allText, $kv[$curCi]['phr'])){
					$rightText .= $kv[$curCi]['phr']; $rightText .= ',';				
					$curCi = $kv[$curCi]['phr'];
					if( $kv[$curCi]['phl'] != $kv[$curCi]['phr']){
						
						preNote($kv, $curCi);
					}
				}else{
					break;
				}
			}
			$arrText[] = array( 'rightText' =>$rightText );
		}else{

		}

		//echo 'leftText is ' . $leftText . '<br />';
		//echo 'rightText is ' . $rightText . '<br />';
		p($arrText);
	}

	function pre2Note($array){
		$curCi = "bac84b1"; // example  root commit;
		$kv = $array;
		while($kv[$curCi]['phl']){
			$leftText .= $kv[$curCi]['phl']; $leftText .= ',';
			$curCi = $kv[$curCi]['phl'];
		}
		$curCi = "bac84b1";
		if( $kv[$curCi]['phl'] != $kv[$curCi]['phr']){
			while( $kv[$curCi]['phr'] != ''){
				if( ! substr_count($leftText, $kv[$curCi]['phr'])){
					$rightText .= $kv[$curCi]['phr']; $rightText .= ',';				
					$curCi = $kv[$curCi]['phr'];
				}else{
					break;
				}
			}
		}
		echo 'leftText is ' . $leftText . '<br />';
		echo 'rightText is ' . $rightText . '<br />';
	}

?>
