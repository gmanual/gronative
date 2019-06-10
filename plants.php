<?php

	function readfilejson($path,$file){
		$json = file_get_contents($path . $file . '.json',FILE_USE_INCLUDE_PATH);
		$json_decode = json_decode($json, TRUE);
	
		foreach($json_decode as $decoded_json){
			$json_item_id = $decoded_json['id'];
			unset ($decoded_json['id']);

			$array[$json_item_id] = $decoded_json;
		}

		return $array;

	}

	$growthForms = readfilejson('./data/','growthForms');
	$conservationTypes = readfilejson('./data/','conservationTypes');
	$biodiversityBenefits = readfilejson('./data/','biodiversityBenefits');
	$bvgs = readfilejson('./data/','bvgs');
	$featureTags = readfilejson('./data/','featureTags');
	$flowingTimes = readfilejson('./data/','flowingTimes');
	$stockist = readfilejson('./data/','stockist');
	$styleTags = readfilejson('./data/','styleTags');
	$suburbs = readfilejson('./data/','suburbs');
	$plants = readfilejson('./data/','plants');

	$plant_fields = array(
			'common_name',
			'species_name',
			'range',
			'description',
			'cultivation',
			'family'
			);

	$plant_arrays[] = array('array_name'=>'growth_forms','index'=>'growthForms');
	$plant_arrays[] = array('array_name'=>'biodiversity_benefits','index'=>'biodiversityBenefits');
	$plant_arrays[] = array('array_name'=>'conservation_status','index'=>'conservationTypes');
	$plant_arrays[] = array('array_name'=>'features_tags','index'=>'featureTags');
	$plant_arrays[] = array('array_name'=>'flowering_times','index'=>'flowingTimes');
	$plant_arrays[] = array('array_name'=>'style_tags','index'=>'styleTags');

	$plant_lists = array('bvg','images');
			

	$cc_plants = array();
	foreach ($plants as $id=>$plant){
		if (in_array('197',$plant['suburbs']) 
		){
			$cc_plants[$id] = array();

			foreach($plant_fields as $field){
				if (isset($plant[$field])){
					$cc_plants[$id][$field] = $plant[$field];
				}
			}

			foreach($plant_arrays as $plant_array){
				if (isset($plant[$plant_array['array_name']])){
					foreach($plant[$plant_array['array_name']] as $temp_id){
						if (isset(${$plant_array['index']}[$temp_id])){
							$cc_plants[$id][$plant_array['array_name']][$temp_id] = ${$plant_array['index']}[$temp_id]['title'];
						}
					}
				}
			}

			foreach($plant_lists as $plant_list){
				if (isset($plant[$plant_list])){
					foreach($plant[$plant_list] as $key=>$temp_id){
						$cc_plants[$id][$plant_list][$key] = $temp_id;
					}
				}
			}
		}
	}

	print_r($cc_plants);
?>
