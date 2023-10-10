<?php

trait uikit3
{
    # Wrapper for the UiKit3 framework
    # https://getuikit.com/docs/form
    
    # default UiKit3 CSS
//    public static function uikit_css($key = '')
//    {
//        return static::uikit3_css($key);
//    }
    
    # default uikit library
//    public function uikit($element = '', $data = '')
//    {
//        return $this->uikit3($element, $data);
//    }
    
    public static function uikit3_css($key = '')
    {
        # uikit3 css classes
        
        $array = [
            'alert-e' => 'uk-alert-danger',
            'alert-i' => 'uk-alert-primary',
            'alert-s' => 'uk-alert-success',
            'alert-w' => 'uk-alert-warning',
            'button' => 'uk-button uk-button-default',
            'submit' => 'uk-button uk-button-default',
            'button-danger' => 'uk-button uk-button-danger',
            'button-primary' => 'uk-button uk-button-primary',
            'button-secondary' => 'uk-button uk-button-secondary',
            'checkbox' => 'uk-checkbox',
            'div' => 'div',
            'error' => 'uk-form-danger',
            'input' => 'uk-input',
            'is-invalid' => 'uk-form-danger',
            'is-valid' => 'uk-form-success',
            'label' => 'uk-form-label',
            'radio' => 'uk-radio',
            'select' => 'uk-select',
            'textarea' => 'uk-textarea',
            'range' => 'uk-range',
            'success' => 'uk-form-success',
            'text-error' => 'uk-form-danger',
        ];
        
        if ($key) {
            return $array[$key];
        } else {
            return $array;
        }
    }

    public function uikit3($element = '', $data = '')
    {
        # uikit3 5 field wrapper
        
        if (empty($data)) {
            return false;
        }
        
        # create our $return variable
        $return = $this->nl;
        
        # optional: add a comment for easier debugging in the html
        $return .= $this->formr->_print_field_comment($data);
        
        # open the wrapping div
        if ($this->formr->type_is_checkbox($data) && ! $this->formr->is_array($data['value'])) {
                $return .= '<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">' . $this->nl;
        } else {
            if ($this->formr->use_element_wrapper_div) {
                $return .= '<div class="uk-margin">' . $this->nl;
            }
        }
        
        # checkbox or radio
        if ($this->formr->type_is_checkbox($data)) {
	        
	        $return .= '<label class="uk-form-label" for="'.$this->formr->make_id($data).'">';
	        $return .= $element;
	        $return .= $data['label'];
	        $return .= $this->formr->insert_required_indicator($data);
	        $return .= '</label>' . $this->nl;
         
        } else {
            
            # add the label
            if ($this->formr->is_not_empty($data['label'])) {
                $return .= '<label for="'.$this->formr->make_id($data).'" class="uk-form-label">';
                $return .= $data['label'];
                $return .= $this->formr->insert_required_indicator($data);
                $return .= '</label>' . $this->nl;
            }
            
            # add the form element
            $return .= '<div class="uk-form-controls">'.$element.'</div>';
        }
        
        # add inline help
        if (! empty($data['inline'])) {
            if ($this->formr->is_in_brackets($data['inline'])) {
                if ($this->formr->in_errors($data['name'])) {
                   # if the text is surrounded by square brackets, show only on form error
                    # trim the brackets and show on error
                    $return .= '<div id="'.$data['name'].'Help" class="form-text text-danger">'.trim($data['inline'], '[]').'</div>' . $this->nl;
                }
            } else {
                # show this text on page load
                $return .= '<div id="'.$data['name'].'Help" class="form-text">'.$data['inline'].'</div>' . $this->nl;
            }
        } else {
            # show error message
            if ($this->formr->in_errors($data['name']) && $this->formr->inline_errors) {
                $return .= '<div class="text-danger">'.$this->formr->errors[$data['name']].'</div>';
            }
        }
        
        # close the wrapping div
        if (($this->formr->type_is_checkbox($data) && ! $this->formr->is_array($data['value'])) || $this->formr->use_element_wrapper_div) {
            $return .= '</div>' . $this->nl;
        }
        
        return $return;
    }

}
