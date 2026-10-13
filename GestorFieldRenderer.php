<?php
declare(strict_types=1);
/** HTML controls generated from MySQL information_schema, not column-name guesses. */
final class GestorFieldRenderer {
    private static function esc(mixed $x): string {
        return htmlspecialchars((string)$x, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    public static function render(string $name, array $meta, bool $insert=true): string {
        $type=strtolower((string)($meta['DATA_TYPE']??'varchar'));
        $full=(string)($meta['COLUMN_TYPE']??$type);
        $extra=strtolower((string)($meta['EXTRA']??''));
        if(str_contains($extra,'auto_increment')||str_contains($extra,'generated'))return '';
        if(in_array($type,['blob','tinyblob','mediumblob','longblob','binary','varbinary','geometry','point','linestring','polygon'],true))return '';
        $escaped=self::esc($name);
        $label='<label class="form-group">'.$escaped;
        $default=$insert&&isset($meta['COLUMN_DEFAULT'])?(string)$meta['COLUMN_DEFAULT']:'';
        if(strtoupper((string)($meta['COLUMN_DEFAULT']??''))==='CURRENT_TIMESTAMP')$default='';
        $required=$insert && ($meta['IS_NULLABLE']??'YES')==='NO' && ($meta['COLUMN_DEFAULT']??null)===null;
        $attrs=' name="field['.$escaped.']" id="field_'.$escaped.'" class="form-control"'.($required?' required':'');
        $value=' value="'.self::esc($default).'"';
        if($type==='enum'||$type==='set'){
            preg_match_all("/'((?:[^'\\\\]|\\\\.)*)'/",$full,$match);
            $values=array_map(static fn($v)=>str_replace("\\'","'",$v),$match[1]);
            if(!$values)return $label.'<input type="text"'.$attrs.$value.'></label>';
            $html=$label.'<select'.$attrs.($type==='set'?' multiple':'').'>';
            if(!$required)$html.='<option value="">—</option>';
            foreach($values as $choice){
                $html.='<option value="'.self::esc($choice).'"'.($choice===$default?' selected':'').'>'.self::esc($choice).'</option>';
            }
            return $html.'</select></label>';
        }
        if(in_array($type,['text','tinytext','mediumtext','longtext','json'],true)){
            return $label.'<textarea'.$attrs.' rows="4">'.self::esc($default).'</textarea></label>';
        }
        $htmlType='text';$other='';
        if(in_array($type,['tinyint','smallint','mediumint','int','integer','bigint','decimal','numeric','float','double','real'],true)){
            $htmlType='number';$other=' step="'.(in_array($type,['decimal','numeric','float','double','real'],true)?'any':'1').'"';
            if(str_contains(strtolower($full),'unsigned'))$other.=' min="0"';
        }elseif($type==='date')$htmlType='date';
        elseif($type==='datetime'||$type==='timestamp')$htmlType='datetime-local';
        elseif($type==='time')$htmlType='time';
        elseif($type==='year'){$htmlType='number';$other=' min="1901" max="2155" step="1"';}
        if(in_array($type,['varchar','char'],true)){
            $limit=(int)($meta['CHARACTER_MAXIMUM_LENGTH']??0);
            if($limit>0&&$limit<65536)$other.=' maxlength="'.$limit.'"';
        }
        if($htmlType==='datetime-local' && $default!=='')$default=str_replace(' ','T',substr($default,0,16));
        return $label.'<input type="'.$htmlType.'"'.$attrs.$other.' value="'.self::esc($default).'"></label>';
    }
}
