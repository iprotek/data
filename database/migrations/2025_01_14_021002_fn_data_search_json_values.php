<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FnDataSearchJsonValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared("DROP FUNCTION IF EXISTS fnGetDataJson");

        DB::unprepared("
CREATE FUNCTION `fnGetDataJson`(_source VARCHAR(100), _target_id INTEGER, _model VARCHAR(500) ) RETURNS longtext CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
BEGIN
	DECLARE _ModelID INT DEFAULT 0;
    DECLARE _DataID INT DEFAULT 0;
    DECLARE _RESULTVALUE LONGTEXT;
    
    
    #DATA SOURCE
    SELECT id INTO _DataID FROM data WHERE ref_source = _source AND ref_id = _target_id LIMIT 1;
    IF(_DataID IS NULL OR _DataID <= 0 )THEN
		RETURN '';
    END IF;
    
    
    ## SELECT MODEL ID
    SELECT id INTO _ModelID FROM data_models WHERE `name` = _model LIMIT 1;
    IF(_ModelID IS NULL OR _ModelID <= 0 )THEN
		RETURN '';
    END IF;
     
    
    SELECT 
		CONCAT('[',
        GROUP_CONCAT(JSON_OBJECT(
			'id',A.id,
            'field',B.`name`,
            'value',IF( A.value_target = 2, A.value2, A.value1),
             'content', CONCAT(B.`name`,':',IF( A.value_target = 2, A.value2, A.value1))
        ))
        ,']') INTO  _RESULTVALUE 
	FROM 
		data_model_field_values AS A,
        ( SELECT B1.name, B2.* FROM model_fields AS B1, data_model_fields AS B2 WHERE B1.id = B2.model_field_id AND B2.data_model_id = _ModelID  )AS B
    WHERE 
		A.data_model_field_id = B.id AND
		B.data_model_id = _ModelID AND
        project_data_id = _DataID;
    
    
RETURN _RESULTVALUE;
END
        ");


        DB::unprepared("DROP FUNCTION IF EXISTS fnGetDataTextValue");

        DB::unprepared("
CREATE FUNCTION `fnGetDataTextValue`(_source VARCHAR(100), _target_id INTEGER, _model VARCHAR(500),  _field_name VARCHAR(100) ) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
BEGIN
	DECLARE _ModelID INT DEFAULT 0;
    DECLARE _DataID INT DEFAULT 0;
    DECLARE _ModelFieldID INT DEFAULT 0;
    DECLARE _DataModelFieldID INT DEFAULT 0;
    DECLARE _RESULTVALUE TEXT;
    
    
    #DATA SOURCE
    SELECT id INTO _DataID FROM data WHERE ref_source = _source AND ref_id = _target_id LIMIT 1;
    IF(_DataID IS NULL OR _DataID <= 0 )THEN
		RETURN '';
    END IF;
    
    
    ## SELECT MODEL ID
    SELECT id INTO _ModelID FROM data_models WHERE `name` = _model LIMIT 1;
    IF(_ModelID IS NULL OR _ModelID <= 0 )THEN
		RETURN '';
    END IF;
    
    ## MODEL FIELD
    SELECT id INTO _ModelFieldID FROM model_fields WHERE `name` = _field_name LIMIT 1;
    IF(_ModelFieldID IS NULL OR _ModelFieldID <= 0 )THEN
		RETURN '';
    END IF;
    
    ## DATA MODEL FIELD
    SELECT id INTO _DataModelFieldID FROM data_model_fields WHERE model_field_id = _ModelFieldID AND data_model_id = _ModelID AND parent_id = 0 LIMIT 1;
    IF(_DataModelFieldID IS NULL OR _DataModelFieldID <= 0 )THEN
		RETURN '';
    END IF;
    
    SELECT 
		IF( value_target = 2, value2, value1) INTO _RESULTVALUE 
	FROM 
		data_model_field_values 
    WHERE 
		data_model_id = _ModelID AND
        data_model_field_id = _ModelFieldID AND
        project_data_id = _DataID LIMIT 1;
    
    
RETURN _RESULTVALUE;
END
        ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
