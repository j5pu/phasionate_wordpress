<?php

if ( ! function_exists( 'vc_has_class' ) ) {
    /**
     * Check if element has specific class
     *
     * E.g. f('foo', 'foo bar baz') -> true
     *
     * @param string $class Class to check for
     * @param string $classes Classes separated by space(s)
     *
     * @return boolean
     */
    function vc_has_class($class, $classes)
    {
        return in_array($class, explode(' ', strtolower($classes)));
    }
}

if ( ! function_exists( 'vc_stringify_attributes' ) ) {
    /**
     * Convert array of named params to string version
     * All values will be escaped
     *
     * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
     *
     * @param $attributes
     *
     * @return string
     */
    function vc_stringify_attributes($attributes)
    {
        $atts = array();
        foreach ($attributes as $name => $value) {
            $atts[] = $name . '="' . esc_attr($value) . '"';
        }

        return implode(' ', $atts);
    }
}