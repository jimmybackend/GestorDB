<?php
declare(strict_types=1);

/** Safe MySQL type-to-HTML adapter. Complex types use explicit text encodings. */
final class GestorFieldRenderer {
    private static function e(mixed $v):string { return htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
    public static function type(array $m):string { return strtolower((string)($m['DATA_TYPE']??'')); }
    public static function choices(string $definition):array {
        preg_match_all("/'((?:''|\\\\.|[^'])*)'/",$definition,$m);
        return array_map(static fn($v)=>str_replace(["\\'","''"],["'","'"],$v),$m[1]);
    }
    public static function kind(array $m):string {
        $t=self::type($m);
        if(str_contains(strtolower((string)($m['EXTRA']??'')),'auto_increment')||str_contains(strtolower((string)($m['EXTRA']??'')),'generated'))return 'generated';
        if(in_array($t,['binary','varbinary','tinyblob','blob','mediumblob','longblob'],true))return 'binary';
        if(in_array($t,['geometry','point','linestring','polygon','multipoint','multilinestring','multipolygon','geometrycollection','geomcollection'],true))return 'spatial';
        if($t==='vector')return 'vector';
        if(in_array($t,['enum','set','json','bit','date','datetime','timestamp','time','year'],true))return $t;
        if(in_array($t,['tinyint','smallint','mediumint','int','integer','bigint','decimal','numeric','float','double','real'],true))return 'number';
        if(in_array($t,['char','varchar','tinytext','text','mediumtext','longtext'],true))return 'text';
        return 'unsupported';
    }
    public static function render(string $name,array $meta,bool $insert=true):string {
        $kind=self::kind($meta);
        if($kind==='generated')return '';
        $n=self::e($name);$t=self::type($meta);
        $rawDefault=$insert?($meta['COLUMN_DEFAULT']??null):null;
        $def=$rawDefault===null||preg_match('/^current_timestamp(?:\(\d+\))?$/i',(string)$rawDefault)?'':(string)$rawDefault;
        $required=$insert&&($meta['IS_NULLABLE']??'YES')==='NO'&&$rawDefault===null;
        $attrs=' name="field['.$n.']" id="field_'.$n.'" class="form-control"'.($required?' required':'');
        $label='<label class="form-group" for="field_'.$n.'">'.$n.' <small>('.self::e($meta['COLUMN_TYPE']??$t).')</small>';
        $full=(string)($meta['COLUMN_TYPE']??$t);
        if($kind==='enum'){
            $options=self::choices($full);$html=$label.'<select'.$attrs.'>';
            if(!$required)$html.='<option value="">—</option>';
            foreach($options as $v)$html.='<option value="'.self::e($v).'"'.($v===$def?' selected':'').'>'.self::e($v).'</option>';
            return $html.'</select></label>';
        }
        if($kind==='set'){
            $html=$label.'<fieldset><legend>Seleccionar valores SET</legend>';
            $selected=$def===''?[]:explode(',',$def);
            foreach(self::choices($full) as $v){
                $html.='<label><input type="checkbox" name="field['.$n.'][]" value="'.self::e($v).'"'.(in_array($v,$selected,true)?' checked':'').'> '.self::e($v).'</label>';
            }
            return $html.'</fieldset></label>';
        }
        if(in_array($kind,['binary','spatial','vector','json','bit'],true)||in_array($t,['tinytext','text','mediumtext','longtext'],true)){
            $hint=match($kind){
                'binary'=>'Base64 de bytes (no nombre de archivo)',
                'spatial'=>'WKT: POINT(1 2), LINESTRING(...), etc.',
                'vector'=>'Vector de números en formato JSON: [0.1,0.2]',
                'bit'=>'Bits: 0 y 1',
                'json'=>'JSON válido',
                default=>'Texto',
            };
            return $label.'<textarea'.$attrs.' rows="3" placeholder="'.self::e($hint).'">'.self::e($def).'</textarea></label>';
        }
        $input='text';$other='';
        if($kind==='number'){
            // BIGINT and exact DECIMAL may exceed JavaScript's safe-number precision: text prevents rounding.
            if(in_array($t,['bigint','decimal','numeric'],true)){$input='text';$other=' inputmode="decimal"';}
            else{$input='number';$other=' step="'.(in_array($t,['float','double','real'],true)?'any':'1').'"';}
            if(str_contains(strtolower($full),'unsigned')&&$input==='number')$other.=' min="0"';
        }elseif($kind==='date')$input='date';
        elseif(in_array($kind,['datetime','timestamp'],true)){$input='datetime-local';if($def!=='')$def=str_replace(' ','T',$def);}
        elseif($kind==='time'){$input='text';$other=' placeholder="HH:MM:SS (admite duraciones negativas y > 24h)"';}
        elseif($kind==='year'){$input='number';$other=' min="1901" max="2155" step="1"';}
        elseif($kind==='unsupported')return $label.'<input type="text"'.$attrs.' readonly placeholder="Tipo no admitido: usar editor especializado"></label>';
        if(in_array($t,['char','varchar'],true)){
            $len=(int)($meta['CHARACTER_MAXIMUM_LENGTH']??0);
            if($len>0&&$len<=65535)$other.=' maxlength="'.$len.'"';
        }
        if(in_array($kind,['datetime','timestamp'],true))$other.=' step="0.000001"';
        return $label.'<input type="'.$input.'"'.$attrs.$other.' value="'.self::e($def).'"></label>';
    }
}
