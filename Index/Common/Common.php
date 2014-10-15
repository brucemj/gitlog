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
?>
