<?php

class UpdateController extends Controller
{
	public function actionIndex() {

		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'  &&  Yii::app()->user->getState('auth')){

		    if ($_POST['stat'] == 'editcheckbox') {
//                $db = Yii::app()->db;
//                $sql = 'UPDATE flowers SET visible_in_menu = '.$_POST['isVisible'].' WHERE id ='.$_POST['id'];
//                $cmd = $db->createCommand($sql);
//                $cmd->execute();
            }

		    elseif ($_POST['stat'] == 'editcheckbox_sef') {
                $db = Yii::app()->db;
                $sql = 'UPDATE flowers SET have_sef = '.$_POST['haveSEO'].' WHERE id ='.$_POST['id'];
                $cmd = $db->createCommand($sql);
                $cmd->execute();

                $sql = 'SELECT * FROM flowers WHERE id='.$_POST['id'];
                $flower = $db->createCommand($sql)->queryAll()[0];

                $sql = 'SELECT * FROM pages WHERE uri="'.$flower['uri'].'"';
                $page_flowers = $db->createCommand($sql)->queryAll()[0];

                $sql = 'SELECT is_visible FROM pages WHERE uri="'.$flower['uri'].'"';
                $is_visible = $db->createCommand($sql)->queryAll()[0]['is_visible'];

                if ($_POST['haveSEO']==1) {
                    if (empty($page_flowers) && empty($is_visible)) {
                        $sql = 'INSERT  INTO  pages (name, uri, text, meta_title, page_title, meta_keywords, meta_description, is_flower, is_visible) VALUES (\''.$flower['name'].'\', \''.$flower['uri'].'\',\''.$flower['text'].'\',\''.$flower['meta_title'].'\',\''.$flower['page_title'].'\',\''.$flower['meta_keywords'].'\',\''.$flower['meta_description'].'\', 1, 1)';
                        $cmd = $db->createCommand($sql);
                        $cmd->execute();
                    }
                }
//                    $sql = 'DELETE from pages where uri = "'.$flower['uri'].'"';
                $sql = 'UPDATE pages SET is_visible = '.$_POST['haveSEO'].' where uri = "'.$flower['uri'].'"';
                $cmd = $db->createCommand($sql);
                $cmd->execute();
            }

		    elseif ($_POST['stat'] == 'edit_feature_product_price') {
                $db = Yii::app()->db;
			    Yii::app()->db->createCommand()->delete('feature_product_price', 'feature_id = :feature_id AND product_id = :id', array(':id' => $_POST['id'], ':feature_id' => $_POST['feature_id']));

				$ArrPrice = explode('|', $_POST['line_price']);
				$ArrPrice = array_diff($ArrPrice, array(''));
				$defPrice = 10000000;
				$arrVal = array();


				foreach ($ArrPrice as $K => $V) {
					$onePrice = explode(':', $V);
					$price = $price = preg_replace("/\D/", "", $onePrice[1]);
					$arrVal[] = $onePrice[0];

                    if ($_POST['feature_id']==12) {
                        $sql = 'SELECT height FROM prices where id='.$onePrice[0];
                        $onePrice[0] = $db->createCommand($sql)->queryScalar();
                    }

					if ($onePrice[1] != '' && $price != ''){
						$db = Yii::app()->db;
						$sql = 'INSERT  INTO  feature_product_price (product_id, feature_id, value, price) VALUES (\''.$_POST['id'].'\', \''.$_POST['feature_id'].'\',\''.$onePrice[0].'\',\''.$price.'\')';
						$cmd = $db->createCommand($sql);
						$cmd->execute();
					}


					if ((int)$price < $defPrice) {
						$defPrice = (int)$price;
					}
				}

                $sql = 'UPDATE  products SET price='.preg_replace("/[^0-9]/", '', $defPrice).' where id='.$_POST['id'];
                $cmd = $db->createCommand($sql);
                $cmd->execute();

				Yii::app()->db->createCommand()->update('features_products', array( 'value'=> implode('|', $arrVal)), 'product_id=:id AND feature_id = :feature_id', array(':id' => $_POST['id'], ':feature_id' => $_POST['feature_id']));
				//Yii::app()->db->createCommand()->update('products', array( 'price'=> $defPrice), 'id=:id', array(':id' => $_POST['id']));


			}

		    elseif ($_POST['stat'] == 'edit_holiday_category') {
//                echo '<pre>';
//                print_r($_POST);
//                die();

                $db = Yii::app()->db;
                $sql = 'UPDATE categories SET typeCategory = '.$_POST['is_holiday'].' WHERE id ='.$_POST['cat_id'];
                $cmd = $db->createCommand($sql);
                $cmd->execute();
            }

		    elseif ($_POST['stat'] == 'product_feature_rose') {
                $db = Yii::app()->db;

//                $sql = 'SELECT value FROM features_products WHERE product_id='.$_POST['product_id'].' AND feature_id='.$_POST['feature_id'];
//                $values_sql = $db->createCommand($sql)->queryAll();
                $sql = 'DELETE from feature_product_price where product_id = '.$_POST['product_id'];
                $cmd = $db->createCommand($sql);
                $cmd->execute();

//                die();


//                $ArrPrice = explode('|', $_POST['line_price']);
//                $ArrPrice = array_diff($ArrPrice, array(''));
//                $defPrice = 10000000;
//                $arrVal = array();
//                foreach ($ArrPrice as $K => $V) {
//                    $onePrice = explode(':', $V);
//                    $price = $price = preg_replace("/\D/", "", $onePrice[1]);
//                    $arrVal[] = $onePrice[0];
//                    if ($onePrice[1] != '' && $price != '') {
//                        $db = Yii::app()->db;
//                        $sql = 'INSERT  INTO  feature_product_price (product_id, feature_id, value, price) VALUES (\'' . $_POST['id'] . '\', \'' . $_POST['feature_id'] . '\',\'' . $onePrice[0] . '\',\'' . $price . '\')';
//                        $cmd = $db->createCommand($sql);
//                        $cmd->execute();
//                    }
//                }


//                echo '<pre>';
//                print_r($_POST);
//                die();



                $last_id = '';
                if (!empty($_POST['via_id']) and $_POST['via_id'] !== 'undefined'){
                    $sql = 'UPDATE products_prices SET price_id = '.$_POST['value'].' WHERE products_prices.id ='.$_POST['via_id'];
                    $cmd = $db->createCommand($sql);
                    $cmd->execute();

                }else{
                    $sql = 'INSERT  INTO  products_prices (product_id, price_id, quantity) VALUES ('.$_POST['product_id'].', '.$_POST['value'].', 1)';
                    $cmd = $db->createCommand($sql);
                    $cmd->execute();
                    $last_id = $db->getLastInsertID();

//                    echo '<pre>';
//                    print_r($insert_feature_product_price);
                }

                $sql2 = 'SELECT p.cost, p.height FROM products_prices as pp, prices as p WHERE pp.product_id='.$_POST['product_id'].' and pp.price_id = p.id order by p.cost asc';
                $insert_feature_product_price = $db->createCommand($sql2)->queryAll();

//                echo '<pre>';
//                print_r($insert_feature_product_price);
//                die();

                if ($_POST['feature_id']==12) {
                    foreach ($insert_feature_product_price as $item) {
                        $sql3 = 'INSERT  INTO  feature_product_price (product_id, feature_id, value, price) VALUES (\'' . $_POST['product_id'] . '\', \'' . $_POST['feature_id'] . '\',\'' . $item['height']. '\',\'' . $item['cost'] . '\')';
                        $cmd = $db->createCommand($sql3);
                        $cmd->execute();

                    }

                        $sql4 = 'UPDATE  products SET price='.$insert_feature_product_price[0]["cost"].' where id='.$_POST['product_id'];
                        $cmd = $db->createCommand($sql4);
                        $cmd->execute();
                }

                $sql = 'select p.* from prices as p where p.id ='.$_POST['value'] ;
                $prices = $db->createCommand($sql)->queryAll();
                $cost = $prices[0]['cost'];

                echo json_encode(['id'=>$last_id, 'cost'=>$cost]);

                $sql = 'select pp.id, pp.price_id, p.height as height from products_prices as pp, prices as p where p.id = pp.price_id and pp.product_id ='.$_POST['product_id'].' order by height asc' ;
                $items = $db->createCommand($sql)->queryAll();

                $values = [];
                if (!empty($items))
                    foreach ($items as $item)
                        $values[] = $item['height'];

                if (!empty($values)){
                    $values = array_unique($values);

                    $sql = 'DELETE from features_products where feature_id = 12 and product_id = '.$_POST['product_id'];
                    $cmd = $db->createCommand($sql);
                    $cmd->execute();

                        $sql = 'INSERT  INTO  features_products (product_id, value, cat_id, feature_id, visibly) VALUES ('.$_POST['product_id'].', "'.implode('|', $values).'", 73, 12, 1)';
                        $cmd = $db->createCommand($sql);
                        $cmd->execute();

                }

            }elseif ($_POST['stat'] == 'product_feature_rose_del') {
                $db = Yii::app()->db;
                if (!empty($_POST['id'])){

                    $sql = 'select pp.* from products_prices as pp where pp.id ='.$_POST['id'] ;
                    $via = $db->createCommand($sql)->queryAll();
                    $product_id = $via[0]['product_id'];

                    $sql2 = "DELETE from feature_product_price where product_id = ".$_POST['flowerID'];
                    $cmd = $db->createCommand($sql2);
                    $cmd->execute();

                    $sql3 = 'DELETE from products_prices where id = '.$_POST['id'];
                    $cmd = $db->createCommand($sql3);
                    $cmd->execute();

                    $sql4 = 'select pp.id, pp.price_id, p.cost, p.height as height from products_prices as pp, prices as p where p.id = pp.price_id and pp.product_id ='.$product_id.' order by height asc' ;
                    $items = $db->createCommand($sql4)->queryAll();

                    $values = [];
                    if (!empty($items))
                        foreach ($items as $item)
                            $values[] = $item['height'];

                    if (!empty($values)){
                        $values = array_unique($values);

                        $sql = 'DELETE from features_products where feature_id = 12 and product_id = '.$product_id;
                        $cmd = $db->createCommand($sql);
                        $cmd->execute();

                        if ($_POST['feature_id']==12) {
                            $sql = 'INSERT  INTO  features_products (product_id, value, cat_id, feature_id, visibly) VALUES ('.$product_id.', "'.implode('|', $values).'", 73, 12, 1)';
                            $cmd = $db->createCommand($sql);
                            $cmd->execute();

                            foreach ($items as $flower) {
                                $sql0 = 'INSERT INTO feature_product_price (product_id, feature_id, price, value) VALUES ('.$_POST["flowerID"].',12,'.$flower["cost"].',"'.$flower["height"].'")';
                                $cmd = $db->createCommand($sql0);
                                $cmd->execute();
                            }
                        }
                    }



                }

            } elseif ($_POST['stat'] == 'edit_feachers_categories' ) {

					$ARR = explode (',', $_POST['value']);

					Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 0), 'feature_id=:id', array(':id' => (int)$_POST['id']));
					Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'feature_id=:id', array(':id' => (int)$_POST['id']));

					if ($ARR[0] != '') {

							foreach ($ARR as $V) {
									$cat_id = str_replace('cat_', '', $V);

									$ARR = Yii::app()->db->createCommand()
									->select('id')
									->from('features_category')
									->where('cat_id='.(int)$cat_id.' AND feature_id= '.(int)$_POST['id'].'')
									->queryRow();

									 if(isset($ARR['id'])) {
									 		Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$_POST['id']));
									 		Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$_POST['id']));

									 } else {

										 	$db = Yii::app()->db;
										 	$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\')';
										 	$cmd = $db->createCommand($sql);
										 	$cmd->execute();

										 	$ARRprod = Yii::app()->db->createCommand()
											->select('t1.id')
											->from('products as t1, products_category as t2')
											->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
											->queryAll();

										 	if (isset($ARRprod[0])) {
											 		foreach ($ARRprod as $V) {
														 	$db = Yii::app()->db;
														 	$sql = 'INSERT  INTO  features_products (cat_id, feature_id, visibly, product_id) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\',\''.$V['id'].'\')';
														 	$cmd = $db->createCommand($sql);
														 	$cmd->execute();
											 		}
										 	}



									 }
							}

					}

			} elseif ($_POST['stat'] == 'addfeatures_tocategory'){

				$ARR = explode (',', $_POST['value']);

				Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 0), 'cat_id=:id', array(':id' => (int)$_POST['id']));
				Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'cat_id=:id', array(':id' => (int)$_POST['id']));

				if ($ARR[0] != 'null') {

						$cat_id = $_POST['id'];
						foreach ($ARR as $V) {

								$features_id = $V;

								$ARR = Yii::app()->db->createCommand()
								->select('id')
								->from('features_category')
								->where('cat_id='.(int)$cat_id.' AND feature_id= '.(int)$features_id.'')
								->queryRow();

								if(isset($ARR['id'])) {
										Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$features_id));
										Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$features_id));

								} else {

										$db = Yii::app()->db;
										$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly) VALUES (\''.$cat_id.'\', \''.$features_id.'\',\'1\')';
										$cmd = $db->createCommand($sql);
										$cmd->execute();

										$ARRprod = Yii::app()->db->createCommand()
										->select('t1.id')
										->from('products as t1, products_category as t2')
										->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
										->queryAll();

										if (isset($ARRprod[0])) {
												foreach ($ARRprod as $V) {
														$db = Yii::app()->db;
														$sql = 'INSERT  INTO  features_products (cat_id, feature_id, visibly, product_id) VALUES (\''.$cat_id.'\', \''.$features_id.'\',\'1\',\''.$V['id'].'\')';
														$cmd = $db->createCommand($sql);
														$cmd->execute();
												}
										}



								}
						}

				}

			} elseif ($_POST['stat'] == 'edit_actions_categories'){
				$ARR = explode (',', $_POST['value']);

				Yii::app()->db->createCommand()->delete( 'actions_category', 'action_id=:id', array(':id' => $_POST['id']));
				Yii::app()->db->createCommand()->delete( 'actions_category_product', 'action_id=:id', array(':id' => $_POST['id']));

				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {

					foreach ($ARR as $V) {
							$cat_id = str_replace('cat_', '', $V);

							$db = Yii::app()->db;
							$sql = 'INSERT  INTO  actions_category (cat_id, action_id, visibly) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\')';
							$cmd = $db->createCommand($sql);
							$cmd->execute();

							$ARRprod = Yii::app()->db->createCommand()
							->select('t1.id')
							->from('products as t1, products_category as t2')
							->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
							->queryAll();
							//print_r($ARRprod);
							if (isset($ARRprod[0])) {
								foreach ($ARRprod as $V) {

									$ARR_ACP = Yii::app()->db->createCommand()
										->select('id')
										->from('actions_category_product')
										->where('prod_id='.$V['id'].' AND action_id= '.$_POST['id'].'')
										->queryRow();

									if(isset($ARR_ACP['id'])) {
									} else {

										$db = Yii::app()->db;
										$sql = 'INSERT  INTO  actions_category_product (action_id, prod_id, visibly) VALUES (\''.$_POST['id'].'\', \''.$V['id'].'\',\'1\')';
										$cmd = $db->createCommand($sql);
										$cmd->execute();
									}
								}
							}
					}

				}

			} elseif ($_POST['stat'] == 'addactions_tocategory'){

				$ARR = explode (',', $_POST['value']);
				$cat_id = $_POST['id'];

				$ARRprod = Yii::app()->db->createCommand()
				->select('t1.id')
				->from('products as t1, products_category as t2')
				->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
				->queryAll();

				$ProdIds = array();
				foreach($ARRprod as $p) {
					$ProdIds[] = $p['id'];
				}

				Yii::app()->db->createCommand()->delete( 'actions_category', 'cat_id=:id', array(':id' => $_POST['id']));
				if (count($ProdIds) > 0){
					Yii::app()->db->createCommand()->delete( 'actions_category_product', 'prod_id IN ('.implode(',', $ProdIds).')');
				}

				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {

						foreach ($ARR as $V) {
							$InsertValues = array();

							$db = Yii::app()->db;
							$sql = 'INSERT  INTO  actions_category (cat_id, action_id, visibly) VALUES (\''.$cat_id.'\', \''.$V.'\',\'1\')';
							$cmd = $db->createCommand($sql);
							$cmd->execute();

							foreach ($ProdIds as $K => $p_id) {
								$InsertValues[] = '(\''.$V.'\', \''.$p_id.'\',\'1\')';
							}
							if (count($InsertValues) > 0) {
								$db = Yii::app()->db;
								$sql = 'INSERT  INTO  actions_category_product (action_id, prod_id, visibly) VALUES '.implode(', ', $InsertValues).'';
								$cmd = $db->createCommand($sql);
								$cmd->execute();
							}
						}
				}

			} elseif ($_POST['stat'] == 'editaction_toproduct' ) {

				$ARR = explode (',', $_POST['value']);

				Yii::app()->db->createCommand()->delete( 'actions_products', 'product_id=:id', array(':id' => $_POST['id']));
				Yii::app()->db->createCommand()->delete( 'actions_category_product', 'prod_id=:id', array(':id' => $_POST['id']));

				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {
					foreach ($ARR as $V) {

						$db = Yii::app()->db;
						$sql = 'INSERT  INTO  actions_products (product_id, action_id, visibly) VALUES (\''.$_POST['id'].'\', \''.$V.'\',\'1\')';
						$cmd = $db->createCommand($sql);
						$cmd->execute();
					}
				}

			} elseif ($_POST['stat'] == 'editfield' ) {




				if ($_POST['field'] == 'newcat_id' && $_POST['f'] == 'products' ) {
						$db = Yii::app()->db;
						//Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));

						$sql = 'DELETE pc FROM products_category pc INNER JOIN categories c ON pc.category_id = c.id WHERE c.typeCategory!=0 AND pc.product_id = '.$_POST['id'];
						$db->createCommand($sql)->execute();


						$ARRnewCat = explode(',', $_POST['value']);
						$Arrcatinsert = array();
						foreach($ARRnewCat as $V) {
							if ($V !='' && $V !='null' && $V != null) $Arrcatinsert[] = '('.$_POST['id'].','.$V.')';
						}
						if (count($Arrcatinsert) > 0){
							$sql = 'INSERT INTO products_category (product_id, category_id) VALUES '.implode(',', $Arrcatinsert);
							$db->createCommand($sql)->execute();
						}
						Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'product_id=:id', array(':id' => (int)$_POST['id']));


						foreach($ARRnewCat as $category_id) {

							$Product_features = Yii::app()->db->createCommand()
							->select('feature_id')
							->from('features_products')
							->where('product_id='.$_POST['id'].'')
							->queryALL();

							$ARR = Yii::app()->db->createCommand()
							->select('feature_id, visibly')
							->from('features_category')
							->where('cat_id='.$category_id.'')
							->queryALL();

							foreach($ARR as $K => $V) {
								$Check = false;

								foreach ( $Product_features as $k2 => $v2) {
									if ($v2['feature_id'] == $V['feature_id']) {
										$Check = true;
									}
								}
								if ($Check) {
									Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> $V['visibly']), 'product_id=:id AND feature_id = :feature_id', array(':id' => $_POST['id'], ':feature_id' => $V['feature_id']));
								} else {
									$sql = 'INSERT  INTO  features_products (cat_id, feature_id, product_id, visibly) VALUES (\''.$category_id.'\', \''.$V['feature_id'].'\', \''.$_POST['id'].'\',\''.$V['visibly'].'\')';
									$db->createCommand($sql)->execute();
								}
							}

						}

				 }
				elseif ($_POST['field'] == 'holiday_id' && $_POST['f'] == 'products') {
                    $db = Yii::app()->db;
                    //Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));

                    $sql = 'DELETE pc FROM products_category pc INNER JOIN categories c ON pc.category_id = c.id WHERE c.typeCategory!=1 AND pc.product_id = '.$_POST['id'];
                    $db->createCommand($sql)->execute();

                    $ARRnewCat = explode(',', $_POST['value']);
                    $Arrcatinsert = array();
                    foreach($ARRnewCat as $V) {
                        if (!empty($V))
                            $Arrcatinsert[] = '('.$_POST['id'].','.$V.')';
                    }
                    if (count($Arrcatinsert) > 0){
                        $sql = 'INSERT INTO products_category (product_id, category_id) VALUES '.implode(',', $Arrcatinsert);
                        $db->createCommand($sql)->execute();
                    }
                    Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'product_id=:id', array(':id' => (int)$_POST['id']));


                    foreach($ARRnewCat as $category_id) {

                        $Product_features = Yii::app()->db->createCommand()
                            ->select('feature_id')
                            ->from('features_products')
                            ->where('product_id='.$_POST['id'].'')
                            ->queryALL();

                        $ARR = Yii::app()->db->createCommand()
                            ->select('feature_id, visibly')
                            ->from('features_category')
                            ->where('cat_id='.$category_id.'')
                            ->queryALL();

                        foreach($ARR as $K => $V) {
                            $Check = false;

                            foreach ( $Product_features as $k2 => $v2) {
                                if ($v2['feature_id'] == $V['feature_id']) {
                                    $Check = true;
                                }
                            }
                            if ($Check) {
                                Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> $V['visibly']), 'product_id=:id AND feature_id = :feature_id', array(':id' => $_POST['id'], ':feature_id' => $V['feature_id']));
                            } else {
                                $sql = 'INSERT  INTO  features_products (cat_id, feature_id, product_id, visibly) VALUES (\''.$category_id.'\', \''.$V['feature_id'].'\', \''.$_POST['id'].'\',\''.$V['visibly'].'\')';
                                $db->createCommand($sql)->execute();
                            }
                        }

                    }
                }

				elseif ($_POST['field'] == 'others' && $_POST['f'] == 'others_products' ) {

				 		$ARR = Yii::app()->db->createCommand()
					 	->select('id')
					 	->from('others_products')
					 	->where('prod_id='.$_POST['id'].'')
					 	->queryRow();

				 		if (isset($ARR['id'])) {
				 			Yii::app()->db->createCommand()->update('others_products', array('others' => $_POST['value']), 'prod_id=:id', array(':id' => $_POST['id']));
				 		} else {
				 			$db = Yii::app()->db;
				 			$sql = 'INSERT  INTO  others_products (prod_id, others) VALUES (\''.$_POST['id'].'\', \''.$_POST['value'].'\')';
				 			$cmd = $db->createCommand($sql);
				 			$cmd->execute();
				 		}
				} elseif ($_POST['field'] == 'hot' && $_POST['f'] == 'products' && $_POST['value'] == 1 ) {
				 	Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));

			 	} elseif ($_POST['field'] == 'season' && $_POST['f'] == 'prices' && $_POST['value'] == 1 ) {
					Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));

				}elseif ($_POST['field'] == 'region_name' && $_POST['f'] == 'delivery_regions' && $_POST['value']) {
					Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));

				}elseif ($_POST['field'] == 'price') {

			 	 	$price = preg_replace("/\D/","",$_POST['value']);
			 	 	Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $price), 'id=:id', array(':id' => $_POST['id']));

			 	 	if ($_POST['f'] == 'products') {
			 	 		$ARRprice = Yii::app()->db->createCommand()
			 	 		->select('id, price')
			 	 		->from('feature_product_price')
			 	 		->where('product_id = '.$_POST['id'].'  order by price ASC')
			 	 		->queryRow();

			 	 		if (isset($ARRprice['id'])){
			 	 			Yii::app()->db->createCommand()->update('feature_product_price', array( 'price'=> $price), 'id=:id', array(':id' => $ARRprice['id']));
			 	 		}
			 	 	}

			 	} elseif ($_POST['field'] == 'cost') {

					$price_id = $_POST['id'];
			 	 	$cost = preg_replace("/\D/", "", $_POST['value']);

			 	 	Yii::app()->db->createCommand()->update($_POST['f'], array($_POST['field'] => $cost), 'id=:id', array(':id' => $price_id));

                    $product_cat = Yii::app()->db->createCommand('SELECT category_id FROM products_category as pc, categories as c WHERE pc.product_id='.$product_id.' and pc.category_id = c.id and c.typeCategory = 1;')->queryScalar();

                    $product_prices = Yii::app()->db->createCommand('SELECT * FROM products_prices WHERE price_id = ' . $price_id)->queryALL();

			 	 	if (!empty($product_prices)) {
			 	 		foreach ($product_prices as $product_price) {

			 	 			$total = 0;
                            $min_price = 99999;
                            $product_cat = Yii::app()->db->createCommand('SELECT category_id FROM products_category as pc, categories as c WHERE pc.product_id='.$product_price['product_id'].' and pc.category_id = c.id and c.typeCategory = 1;')->queryScalar();

                            $prices = Yii::app()->db->createCommand('SELECT product_id, price_id, quantity FROM products_prices WHERE product_id = ' . $product_price['product_id'])->queryALL();
                            
                            if ($product_cat == 73) {
                                foreach ($prices as $price) {
                                    $row = Yii::app()->db->createCommand('SELECT cost FROM prices WHERE id = ' . $price['price_id'])->queryRow();

                                    if ($row['cost'] < $min_price)
                                        $min_price = $row['cost'];
                                }

                                $total = $min_price;
                            } else {
                                foreach ($prices as $price) {
                                    $row = Yii::app()->db->createCommand('SELECT cost FROM prices WHERE id = ' . $price['price_id'])->queryRow();

                                    if ($row['cost'] > 0)
                                        $total += $row['cost'] * $price['quantity'];
                                }
                            }

			 	 			Yii::app()->db->createCommand()->update('products', array('price'=> $total, 'price_update' => time()), 'id=:id', array(':id' => $product_price['product_id']));

			 	 		}
			 	 	}

                    if (!empty($product_prices_height))
                        foreach ($product_prices_height as $product_price)
                            Yii::app()->db->createCommand()->update('feature_product_price', array('price'=> $_POST['value']), 'product_id=:product_id and value=:value', array(':product_id' => $product_price['product_id'],':value' => $product_price['height']));

				}elseif ($_POST['stat'] == 'editfield' && $_POST['field'] == 'florist_services_price') {
					$product_id = $_POST['id'];
					$products_price_data = Yii::app()->db->createCommand('SELECT price_id, quantity FROM products_prices WHERE product_id = ' . $product_id)->queryAll();
					$florist_services_price = $_POST['value'];

                    $product_cat = Yii::app()->db->createCommand('SELECT category_id FROM products_category as pc, categories as c WHERE pc.product_id='.$product_id.' and pc.category_id = c.id and c.typeCategory = 1;')->queryScalar();

					$total = 0;

					$min_price = 99999;
					//если роза
                    if ($product_cat == 73) {
                        foreach ($products_price_data as $product_price) {

                            $price_id = $product_price['price_id'];
                            $quantity = $product_price['quantity'];

                            if ($price_id > 0 && $quantity > 0) {
                                $row = Yii::app()->db->createCommand('SELECT cost FROM prices WHERE id = ' . $price_id)->queryRow();

                                if ($row['cost'] < $min_price)
                                    $min_price = $row['cost'];
                            }
                        }

                        $total = $min_price;

                    } else {
                        foreach ($products_price_data as $product_price) {

                            $price_id = $product_price['price_id'];
                            $quantity = $product_price['quantity'];

                            if ($price_id > 0 && $quantity > 0) {
                                $row = Yii::app()->db->createCommand('SELECT cost FROM prices WHERE id = ' . $price_id)->queryRow();

                                if ($row['cost'] > 0)
                                    $total += $row['cost'] * $quantity;
                            }
                        }

                        $total += (int)$florist_services_price;
                    }
                    
					Yii::app()->db->createCommand()->update('products', array('price'=> $total, 'price_update' => time()), 'id=:id', array(':id' => $product_id));
					Yii::app()->db->createCommand()->update('products', array( 'florist_services_price'=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));
                }elseif ($_POST['stat'] == 'editfield' && $_POST['field'] == 'page_title') {
//                    Yii::app()->db->createCommand()->update('categories', array( 'name'=> $_POST['value'], 'page_title'=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));
                    Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id='. $_POST['id']);
				} else {
                    $db = Yii::app()->db;

                    $sql = 'SELECT uri FROM pages WHERE id='.$_POST['id'];
                    $oldUri = $db->createCommand($sql)->queryScalar();

				    $ARRvalue = explode('|',$_POST['value']);

                    $flowers = Yii::app()->db->createCommand('SELECT name FROM flowers')->queryColumn();

                    $addFlower = reset(array_diff($ARRvalue, $flowers));

//                    echo '1';
//                    die();

                    if ($_POST['field']=='maindescription') {
                        Yii::app()->db->createCommand()->update($_POST['f'], array( 'main_description'=> $_POST['value']), 'id='. $_POST['id']);
                    } else {
                        Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id='. $_POST['id']);

                        $sql = 'SELECT product_id FROM prices p, products_prices pr WHERE p.id = pr.price_id and p.order = 1';
                        $is_ready_product = $db->createCommand($sql)->queryAll();

                        $sql0 = 'UPDATE products SET is_ready=1 WHERE id>0';
                        $cmd = $db->createCommand($sql0);
                        $cmd->execute();

                        foreach ($is_ready_product as $key => $item) {
                            $sql = 'UPDATE products SET is_ready=0 WHERE id='.$item['product_id'];
                            $cmd = $db->createCommand($sql);
                            $cmd->execute();
                        }
                    }

				 	if ($addFlower && $_POST['field']=='variants') {
                        $flowers = Yii::app()->db->createCommand('SELECT * FROM flowers where uri="'.$_POST['old_uri'].'"')->queryColumn();
                        if (empty($flowers))
                            Yii::app()->db->createCommand("INSERT INTO `flowers` (`name`, `visible_in_menu`, `uri`) VALUES ('".$addFlower."', '0', '".$this->translit($addFlower)."');")->execute();
                        else
                            Yii::app()->db->createCommand("UPDATE flowers SET name='".$_POST['name']."' WHERE uri='".$_POST['old_uri']."'")->execute();
                            Yii::app()->db->createCommand("UPDATE pages SET name='".$_POST['name']."' WHERE uri='".$_POST['old_uri']."'")->execute();
                    }



//                    echo '<pre>';
//                    print_r($oldUri);
//                    die();

				 	if ($_POST['field']=='uri') {
                        $db = Yii::app()->db;
                        $sql = 'UPDATE flowers SET uri = "'.$_POST['value'].'" WHERE uri ="'.$oldUri.'"';
                        $cmd = $db->createCommand($sql);
                        $cmd->execute();
                    }


//				 	$str = Yii::app()->db->createCommand('select variants from features where id = 10')->queryRow();
//				 	$arr = explode('|', $str['variants']);
//				 	foreach ($arr as $a){
//                        Yii::app()->db->createCommand("INSERT INTO `flowers` (`id`, `name`, `visible_in_menu`, `uri`) VALUES (NULL, '".$a."', '0', '".$this->translit($a)."');")->execute();
//                    }
				}


			} elseif ($_POST['stat'] == 'sort'){
				$ArrCat = explode('|', $_POST['sort_line']);
				foreach ($ArrCat as $V){
					if ($V!= ''){
						$Arrsort = explode('-', $V);
						Yii::app()->db->createCommand()->update($_POST['f'], array( 'orders'=> $Arrsort[1]), 'id=:id', array(':id' => $Arrsort[0]));
					}
				}


			} elseif ($_POST['stat'] == 'change_page_in_menu') {


//		        echo '<pre>';
//		        print_r($_POST);
//		        die();

                $db = Yii::app()->db;
                $sql = 'UPDATE flowers SET have_sef='.$_POST['isVisible'].', visible_in_menu = '.$_POST['isVisible'].' WHERE uri ="'.$_POST['uri'].'"';
                $cmd = $db->createCommand($sql);
                $cmd->execute();



            } elseif ($_POST['stat'] == 'check_mono_byket') {

                $db = Yii::app()->db;
                $sql = 'UPDATE products SET is_mono_byket='.$_POST['isMono'].' WHERE id ="'.$_POST['id'].'"';
                $cmd = $db->createCommand($sql);
                $cmd->execute();

            } elseif ($_POST['stat'] == 'addnew'){

				$db = Yii::app()->db;


				if ($_POST['f'] == 'categories') {
					$_POST['uri'] = $this->module->translit($_POST['uri']);
					if (isset($_POST['need'])) {
						echo $_POST['uri'];
					}
				}



				$line_field = array();
				$line_value = array();


					foreach ($_POST as $K => $V) {
						if ($K != 'stat' && $K != 'f' && $K != 'need' ) {
							$line_field[] = $K;
							$line_value[] = "'".$V."'";
						}
					}
					if ($_POST['f'] == 'reviews'){
						$line_field[] = 'ts';
						$line_value[] = "".time()."";
					}

//					echo '<pre>';
//					print_r($_POST);

					$sql = 'INSERT  INTO  '.$_POST['f'] .' ('.implode(',', $line_field).') VALUES ('.implode(',', $line_value).')';
					$cmd = $db->createCommand($sql);
					$cmd->execute();

				if ($_POST['f'] == 'categories') {
					$ARROne = Yii::app()->db->createCommand()
					->select('id')
					->from('features')
					->where('tocart="1" ')
					->queryRow();

					$_ID = Yii::app()->db->getLastInsertID(''.$_POST['f'].'');

					if (!isset($_POST['need'])) {
						echo $_ID;
					}

					$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly ) VALUES (\''.$_ID.'\', \''.$ARROne['id'].'\',\'1\')';
					$cmd = $db->createCommand($sql);
					$cmd->execute();
				} elseif ($_POST['f'] == 'products'){

					echo $product_id = Yii::app()->db->getLastInsertID(''.$_POST['f'].'');

					$arrCategory = explode(',', $_POST['cat_id']);
					$arrcatSelect = array();
					$arrcatInsert = array();

					foreach ($arrCategory as $cat) {
						if ($cat!= '' && $cat!= 'null' && $cat!= null) {
							$arrcatSelect[] = 't2.cat_id = '.$cat;
							$arrcatInsert[] = '('.$product_id.','.$cat.')';
						}
					}
					if (count($arrcatInsert) > 0){
						$sql = 'INSERT  INTO  products_category (product_id, category_id) VALUES '.implode(',', $arrcatInsert).'';
						$db->createCommand($sql)->execute();
					}

					if (count($arrcatSelect) > 0){
						$ArrcatFeat = Yii::app()->db->createCommand()
						->select('t1.*')
						->from('features as t1, features_category as t2 ')
						->where('t1.id = t2.feature_id AND ( '.implode(' OR ',$arrcatSelect).')')
						->queryALL();

						foreach($ArrcatFeat as $K => $V) {

								$sql = 'INSERT  INTO  features_products (product_id, feature_id, cat_id, visibly) VALUES (\''.$product_id.'\', \''.$V['id'].'\', \''.$_POST['cat_id'].'\',\'1\')';
			 					$cmd = $db->createCommand($sql);
			 					$cmd->execute();
						}
					}

				} else {
					if (!isset($_POST['need'])) {
						echo $product_id = Yii::app()->db->getLastInsertID(''.$_POST['f'].'').'';
					}

				}



			} elseif ($_POST['stat'] == 'delflower') {
		        $value = $_POST['value'];

		        echo $value;

                $db = Yii::app()->db;
                $sql = "DELETE FROM flowers WHERE name='$value'";
                $db->createCommand($sql)->execute();
            }

		    elseif ($_POST['stat'] == 'delete') {
				if ($_POST['f'] == 'features') {
					$ARROne = Yii::app()->db->createCommand()
					->select('tocart')
					->from('features')
					->where('id='.$_POST['id'].' ')
					->queryRow();

					if ($ARROne['tocart'] != '1') {
						Yii::app()->db->createCommand()->delete($_POST['f'], 'id=:id', array(':id' => $_POST['id']));
					}
				} else {
					Yii::app()->db->createCommand()->delete($_POST['f'], 'id=:id', array(':id' => $_POST['id']));
				}

				if ($_POST['f'] == 'products') {
					Yii::app()->db->createCommand()->delete('features_products', 'product_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'features') {
					Yii::app()->db->createCommand()->delete('features_products', 'feature_id=:id', array(':id' => $_POST['id']));
					Yii::app()->db->createCommand()->delete('features_category', 'feature_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'categories') {
					Yii::app()->db->createCommand()->delete('features_category', 'cat_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'actions') {
					Yii::app()->db->createCommand()->delete('actions_products', 'feature_id=:id', array(':id' => $_POST['id']));
					Yii::app()->db->createCommand()->delete('actions_category', 'feature_id=:id', array(':id' => $_POST['id']));
				}
			} elseif ($_POST['stat'] == 'edit_products_prices') {
                $db = Yii::app()->db;
				$product_id = $_POST['product_id'];
				Yii::app()->db->createCommand()->delete('products_prices', 'product_id = :id', array(':id' => $product_id));

				$data = explode('|', $_POST['data']);
				$names_flowers = str_replace(',','|', $_POST['names_flowers']);
				$data = array_diff($data, array(''));

				$total = 0;

				$data_price = explode('|', $_POST['data']);

				$price_info_arr = [];
				foreach ($data_price as $key => $item) {
				    if (!empty($item)) {
                        $price_info_arr[$key]['price_id'] = explode(':', $item)[0];
                        $price_info_arr[$key]['count'] = explode(':', $item)[1];
                    }
                }

				$total_sum = 0;
				foreach ($price_info_arr as $key => $item) {
                    $sql = 'SELECT cost FROM prices WHERE id='.$item['price_id'];
                    $price = $db->createCommand($sql)->queryScalar();
                    $total_sum += $price_info_arr[$key]['count']*$price;
                }

//                print_r($total_sum);

                $sql = 'UPDATE products SET price = "'.$total_sum.'" WHERE id ="'.$_POST['product_id'].'"';
                $cmd = $db->createCommand($sql);
                $cmd->execute();




				foreach ($data as $product_price) {
					$price = explode(':', $product_price);

					$price_id = $price[0];
					$quantity = $price[1];

					if ($price_id > 0 && $quantity > 0) {
						$row = Yii::app()->db->createCommand('SELECT cost FROM prices WHERE id = ' . $price_id)->queryRow();

						if ($row['cost'] > 0)
							$total += $row['cost'] * $quantity;

						Yii::app()->db->createCommand('INSERT INTO products_prices (product_id, price_id, quantity) VALUES ('.$product_id.', '.$price_id.', '.$quantity.')')->execute();

						Yii::app()->db->createCommand('UPDATE features_products SET `visibly`=1 WHERE feature_id = 10 AND product_id = ' . $product_id)->execute();

					}
				}

                Yii::app()->db->createCommand('UPDATE features_products SET `value`="'.$names_flowers.'" WHERE feature_id = 10 AND product_id = ' . $product_id)->execute();



//				Yii::app()->db->createCommand()->update('products', array(
//					'price'=> $total,
//					'price_update' => time()),
//					'id=:id',
//					array(':id' => $product_id));

//				echo '<pre>';
//				echo $names_flowers;
//				die();

                $sql = 'SELECT product_id FROM prices p, products_prices pr WHERE p.id = pr.price_id and p.order = 1';
                $is_ready_product = $db->createCommand($sql)->queryAll();

                $sql0 = 'UPDATE products SET is_ready=1 WHERE id>0';
                $cmd = $db->createCommand($sql0);
                $cmd->execute();

                foreach ($is_ready_product as $key => $item) {
                    $sql = 'UPDATE products SET is_ready=0 WHERE id='.$item['product_id'];
                    $cmd = $db->createCommand($sql);
                    $cmd->execute();
                }


			}elseif ($_POST['stat'] == 'product_rose') {
                $product_id = $_POST['product_id'];
                $checked = $_POST['checked'];
                $db = Yii::app()->db;
                $sql = "UPDATE `products` SET `visible_in_roses` = ".$checked." WHERE `products`.`id` = ".$product_id;
                $db->createCommand($sql)->execute();
            }
		}
	}

    public function translit($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            "."=>""," "=>"","?"=>"","/"=>"","\\"=>"",
            "*"=>"",":"=>"","*"=>"","\""=>"","<"=>"",
            ">"=>"","|"=>""
        );
        return strtolower(strtr($str,$tr));
    }

	public function actionProductpopup() {

		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' &&  Yii::app()->user->getState('auth')){

			if (isset($_POST['cat']) && $_POST['stat'] == 'start'){

				$cat = $_POST['cat'];

				$Arrcat = Yii::app()->db->createCommand()
				->select('*')
				->from('categories')
				->where('id!="" ORDER BY orders ASC ')
				->queryALL();

				$i= 1;
				$MenuCat = '';
				foreach ($Arrcat as $k=> $V){
					$style = '';
					if ($cat == '' && $k == 0) {
						$cat_id = $V['id']; $style='menu_select';
					}else {
						if ($cat == $V['uri']){ $cat_id = $V['id']; $style='menu_select';}
					}
					$MenuCat .= '<div class="one_left_menu '.$style.'" id="'.$V['id'].'" >'.$V['name'].'</div>';
					$i++;
				}
				echo '<div class="popup_left">'.$MenuCat.'</div>';


			}else {
				$cat_id = $_POST['cat_id'];
			}

			$sql = 'SELECT p.* FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id  WHERE pc.category_id = '.$cat_id.' GROUP by p.id ORDER by p.orders';
			$Array = Yii::app()->db->createCommand($sql)->queryAll();


			if (count($Array) === 0 ){

				echo  '<div class="popup_right">В этой категории нет товаров</div><div class="br"></div>';
			}
			$n = 1;
			$line = '';
			foreach ($Array as $k => $V){


				$select_size = '';

				$Arrimg = explode('|', $V['img']);
				$Arrimg = array_diff($Arrimg, array(''));
				if (count($Arrimg) > 0){
					$line .= '<div class="popup_one_products " id="'.$V['id'].'">
									<div class="popup_one_products_img"><img src="/uploads/81x84/'.current($Arrimg).'"></div>
									<div class="popup_one_products_name">'.$V['name'].'</div>
									'.$select_size.'
							</div>
					';
				}
			}
			if (count($Array) != 0 ){
				echo '<div class="popup_right">'.$line.'</div><div class="br"></div>';
			}

		}
	}

	
}
