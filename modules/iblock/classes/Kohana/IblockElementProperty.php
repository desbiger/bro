<?

class Kohana_IblockElementProperty extends ORM
{

    public static function GetByIblockID($id)
    {
        $property = ORM::factory('Property');

    }

    /**
     * @param $id
     * @return ORM
     * ����� ���������� ������
     */
    public static function GetPropertyTypeByID($id)
    {
        return ORM::factory('PropertyType', $id);
    }


    /**
     * @param $element_id
     * @param $property_id
     * @param $vol
     * @param bool $vol_id
     * ��������� �������� �������� $property_id ��� �������� $element_id
     */
    public static function UpdateProperty($element_id, $property_id, $vol, $vol_id = false)
    {
        $value = ORM::factory('PropertyValue')
            ->where('element_id', "=", $element_id)
            ->and_where('property_id', "=", $property_id);

        if ($vol_id) {
            $value->and_where('id', '=', $vol_id);
        }
        $value->find();

        if ($value->loaded() && $vol_id) {
            $value->set('value', $vol);
            $value->set('element_id', $element_id);
            $value->set('property_id', $property_id);
            $value->update();
        } else {
            ORM::factory('PropertyValue')
                ->set('element_id', $element_id)
                ->set('value', $vol)
                ->set('property_id', $property_id)
                ->save();
        }
    }

    /**
     * @param $filter
     * @return Database_Result
     * ������ ���� ������� �� ������� $filter
     */
    static public function GetValues($filter)
    {
        $propertyValues = ORM::factory('PropertyValue');
        //			$propertyValues->and_where_open();
        foreach ($filter as $k => $v) {
            $propertyValues->and_where($k, '=', $v);
        }
        //			$res = $propertyValues->and_where_close();
        return $propertyValues->find_all();
    }

    /**
     * @param $iblock_id
     * @param $element_id
     * @return array
     * �������� ������ ���� �����, ������� ���� ����� � �������� ���� �������
     * ��� �������� $element_id
     * � ���������  $iblock_id
     */
    public static function GetList($iblock_id, $element_id = null)
    {
        $result = array();
        $groups = ORM::factory('PropertyGroup')
            ->where('block_id', '=', $iblock_id)
            ->find_all();

        foreach ($groups as $group) {
            $props = ORM::factory('Property')
                ->where('block_id', "=", $iblock_id)
                ->where('group_id', "=", $group->id)
                ->find_all();
            $result['GROUPS'][$group->id] = $group->as_array();
            foreach ($props as $props_v) {
                $propValues = ORM::factory('PropertyValue');
                $dot = $props_v->as_array();
                if ($props_v->many) {
                    $values = array();
                    $l = $propValues->where('property_id', '=', $props_v->id)
                        ->and_where('element_id', '=', $element_id)
                        ->find_all();
                    foreach ($l as $v) {
                        $values[] = $v->value;
                    }
                    $dot['value'] = $values;
                    $list = $dot;
                    $result['GROUPS'][$group->id]['PROPERTIES'][$props_v->id] = $list;
                } else {
                    $values = '';
                    $l = $propValues->where('property_id', '=', $props_v->id)
                        ->and_where('element_id', '=', $element_id)
                        ->find();
                    if ($l->loaded()) {
                        $values = $l->value;
                    }

                    $dot['value'] = $values;
                    $list = $dot;
                    $result['GROUPS'][$group->id]['PROPERTIES'][$props_v->id] = $list;
                }
            }
        }

        return $result;
    }


    //удаляем значения свойств
    public static function RemovePropertiesValue($arDelete)
    {
        $ob = ORM::factory('PropertyValue')
            ->where('id', 'IN', $arDelete)
            ->find_all();

        foreach ($ob as $v) {
            $v->delete();
        }
    }

    //удаляем свойства
    public static function RemoveProperties($arDelete)
    {
        $ob = ORM::factory('Property')
            ->where('id', 'IN', $arDelete)
            ->find_all();

        foreach ($ob as $v) {
            $v->delete();
        }

        $ob = ORM::factory('PropertyValue')
            ->where('property_id', 'IN', $arDelete)
            ->find_all();
        $ar = array();
        foreach ($ob as $v) {
            $ar[] = $v->id;
        }

        if (count($ar) > 0){
            IblockElementProperty::RemovePropertiesValue($ar);
        }
    }

    //удаляем категории
    public static function RemoveCategories($id)
    {
            ORM::factory('PropertyGroup')
            ->where('id', '=', $id)
            ->find()
            ->delete();

            $ob = ORM::factory('Property')
            ->where('group_id', '=', $id)
            ->find_all();
        $ar = array();
        foreach ($ob as $v) {
            $ar[] = $v->id;
        }
            if (count($ar) > 0){
                IblockElementProperty::RemoveProperties($ar);
            }


    }

}
 