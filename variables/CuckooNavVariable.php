<?php
/**
 * Cuckoo Nav plugin for Craft CMS
 *
 * Cuckoo Nav Variable
 *
 * @author    cole007
 * @copyright Copyright (c) 2018 cole007
 * @link      http://ournameismud.co.uk/
 * @package   CuckooNav
 * @since     0.0.1
 */

namespace Craft;

class CuckooNavVariable
{
    /**
     */
    public function array_depth($array) {
        $max_indentation = 1;

        $array_str = print_r($array, true);
        $lines = explode("\n", $array_str);

        foreach ($lines as $line) {
            $indentation = (strlen($line) - strlen(ltrim($line))) / 4;

            if ($indentation > $max_indentation) {
                $max_indentation = $indentation;
            }
        }

        return ceil(($max_indentation - 1) / 2) + 1;
    }    
    public function returnKids($key, $value, $elements, $depth)
    {
        $results = array();        
        $results = new \stdClass();
        $tmpElement = $this->search($elements,'id',$key);
        if(empty($tmpElement)) return false;
        $results->element = $tmpElement;
        $results->depth = $depth;
        // $results['element'] = $this->search($elements,'id',$key);
        $tmp = [];
        if (is_array($value)) {
            $tmpKids = [];
            foreach ($value AS $childKey => $childValue) {
                $tmpKids[] = $this->returnKids($childKey,$childValue,$elements,($depth+1));
            }    
            $tmp = $tmpKids;
        } 
        // Craft::dd($tmp);
        $results->children = $tmp;
        // $kids = $array[$key];
        // var_dump($array[$key]);
        // if (count($value) > 0) {
        //     $tmpKids = []; 
        //     foreach ($value AS $subKey => $subValue) {
        //         $tmpKids[] = $this->search($elements,'id',$subKey); 
        //     }
        //     $navOutput[$key]['children'] = $tmpKids;
        // }
        return $results;
    }
    public function search($array, $key, $value)
	{
		$results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, $this->search($subarray, $key, $value));
	        }
	    }
	    if (count($results) == 1) $results = $results[0];
	    return $results;
	}
    public function getNav($handle)
    {
        $section = craft()->db->createCommand()
        	->from('{{sections}}')
        	->where(['handle' => $handle])
        	->queryRow();

        // Craft::dd($section);
        // $nav = [];
     //    $array = [];
        $nav = craft()->db->createCommand()
        	->from('{{structureelements}}')
        	->where(['structureId' => $section['structureId']])
        	->order('lft')
        	->queryAll();
        // $array = [];
        $tmpElement = [];
        $tmpIds = [];
        foreach ($nav AS $navItem) {
        	$tmpIds[] = $navItem['elementId'];
            if ($navItem['level'] == 1) {
        		$tmpIndex = $navItem['elementId'];
        		$tmpElement[$tmpIndex] = [];
        	} elseif ($navItem['level'] == 2) {
        		$tmpIndex_2 = $navItem['elementId'];
                $tmpElement[$tmpIndex][$tmpIndex_2] = [];
        	} elseif ($navItem['level'] == 3) {
                $tmpIndex_3 = $navItem['elementId'];
                $tmpElement[$tmpIndex][$tmpIndex_2][$tmpIndex_3] = [];
                // $tmpIndex_3 = $navItem['elementId'];
        		// $root = $tmpElement[$tmpIndex][$tmpIndex_2];
        		// if(!array_key_exists($tmpIndex_3,$root)) {
        		// 	// $tmpElement[$tmpIndex][$tmpIndex_2]['children'][] = [
        		// 	// 	'id' => $tmpIndex_3,
        		// 	// 	'children' => []
        		// 	// ];
        		// }
    //     		$key = $tmpElement[$tmpIndex][$tmpIndex_2];
    //     		if(!array_key_exists($tmpIndex_3,$key)) $key[$tmpIndex_3] = [];
				// $key[$tmpIndex_2][] = $navItem['elementId'];
        	} elseif ($navItem['level'] == 4) {
				// $tmpIndex_4 = $navItem['elementId'];
               $tmpIndex_4 = $navItem['elementId'];
               $tmpElement[$tmpIndex][$tmpIndex_2][$tmpIndex_3][$tmpIndex_4] = [];
        	} elseif ($navItem['level'] == 5) {
        		// $tmpIndex_5 = $navItem['elementId'];        	
                $tmpIndex_5 = $navItem['elementId'];
                $tmpElement[$tmpIndex][$tmpIndex_2][$tmpIndex_3][$tmpIndex_4][] = $tmpIndex_5;
        	}
        	// $tmp
        }
        $elements = craft()->db->createCommand()
            ->select('co.elementId AS id, title, uri AS url')
            ->from('{{elements_i18n}} eli')
            ->join('{{content}} co','co.elementId = eli.elementId')
            ->join('{{elements}} el','el.id = eli.elementId')
            ->where(['co.locale' => craft()->language,'el.enabled' => 1])
            ->andwhere(['in','co.elementId',array_filter($tmpIds)])
            ->queryAll();
        // Craft::dd($elements);
        $navOutput = [];   
        // $navOutput = new stdClass();
        // echo '<pre>';
        foreach ($tmpElement AS $key => $value) {
            $tmpElement = $this->search($elements,'id',$key);
            if(empty($tmpElement)) continue;
            // $tmp->element = $tmpElement;
            // Craft::dd($this->returnKids($key,$value,$elements));
            // $tmp->children = (array)$this->returnKids($key,$value,$elements);
            // Craft::dd($tmp);
            $navOutput[$key] = (array)$this->returnKids($key,$value,$elements, 1);
            // echo $key . ': ' . $this->array_depth($navOutput[$key]) . '<br />';
            // $navOutput[$key]['element'] = $this->search($elements,'id',$key);
            // $navOutput[$key]['children'] = $this->returnKids($key,$value,$elements);
            // $tmpKids = [];
            // foreach ($value AS $subKey => $subValue) {
            //     // recursive here!!!
            //     $tmpKid = [];
            //     $tmpKid['element'] = $this->search($elements,'id',$subKey);
            //     $tmpKids_2 = [];
            //     foreach ($subValue AS $subKey_2 => $subValue_2) {
            //         $tmpKid_2 = [];
            //         $tmpKid_2['element'] = $this->search($elements,'id',$subKey_2);
            //         $tmpKids_3 = [];
            //         foreach ($subValue_2 AS $subKey_3 => $subValue_3) {
            //             $tmpKid_3 = [];
            //             $tmpKid_3['element'] = $this->search($elements,'id',$subKey_3);
            //             $tmpKids_4 = [];
            //             foreach ($subValue_3 AS $subKey_4 => $subValue_4) {
            //                 // $tmpKid_4 = [];
            //                 // $tmpKid_4['element'] = $this->search($elements,'id',$subKey_4);
            //                 // $tmpKids_5 = [];
            //                 // if (is_array($subValue_4)) {
            //                 //     foreach ($subValue_4 AS $subKey_5 => $subValue_5) {
            //                 //         $tmpKid_5 = [];
            //                 //         $tmpKid_5['element'] = $this->search($elements,'id',$subKey_5);
            //                 //         $tmpKids_5[] = $tmpKid_5;
            //                 //     }
            //                 // } elseif (is_string($subValue_4)) {
            //                 //     $tmpKids_5[] = $this->search($elements,'id',$subKey_4);
            //                 // }
            //                 // $tmpKid_4['children'] = $tmpKids_5;
            //                 // $tmpKids_4[] = $tmpKid_4;
            //             }
            //             $tmpKid_3['children'] = $tmpKids_4;
            //             $tmpKids_3[] = $tmpKid_3;
            //         }
            //         $tmpKid_2['children'] = $tmpKids_3;
            //         $tmpKids_2[] = $tmpKid_2;
            //     }
            //     $tmpKid['children'] = $tmpKids_2;
            //     $tmpKids[] = $tmpKid;
            // }                
            // $navOutput[$key]['children'] = $tmpKids;
        }
        

        // Craft::dd($navOutput);        
        return $navOutput;
    }
}	