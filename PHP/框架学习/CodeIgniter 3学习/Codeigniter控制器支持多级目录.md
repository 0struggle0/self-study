< ?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class MY_Router extends CI_Router
{
        // --------------------------------------------------------------------

        /**
         *  Set the directory name
         *
         * @access        public
         * @param        string
         * @return        void
         */
        function set_directory($dir)
        {
                $this->directory = $dir.'/';
        }
     
        /**
         * Validates the supplied segments.  Attempts to determine the path to
         * the controller.
         *
         * @access        private
         * @param        array
         * @return        array
         */
     
        function _validate_request($segments)
        {
                if (count($segments) == 0)
                {
                        return $segments;
                }
     
                // Does the requested controller exist in the root folder?
                if (file_exists(APPPATH.'controllers/'.$segments[0].'.php'))
                {
                        return $segments;
                }
     
                // Is the controller in a sub-folder?
                if (is_dir(APPPATH.'controllers/'.$segments[0]))
                {
                        $temp = array('dir' => '', 'number' => 0, 'path' => '');
                        $temp['number'] = count($segments) - 1;
     
                        for($i = 0; $i <= $temp['number']; $i++)
                        {
                                $temp['path'] .= $segments[$i].'/';
     
                                if(is_dir(APPPATH.'controllers/'.$temp['path']))
                                {
                                        $temp['dir'][] = str_replace(array('/', '.'), '', $segments[$i]);
                                }
                        }
     
                        $this->set_directory(implode('/', $temp['dir']));
                        $segments = array_diff($segments, $temp['dir']);
                        $segments = array_values($segments);
                        unset($temp);
     
                        if (count($segments) > 0)
                        {
                                // Does the requested controller exist in the sub-folder?
                                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].'.php'))
                                {
                                        if ( ! empty($this->routes['404_override']))
                                        {
                                                $x = explode('/', $this->routes['404_override']);
     
                                                $this->set_directory('');
                                                $this->set_class($x[0]);
                                                $this->set_method(isset($x[1]) ? $x[1] : 'index');
     
                                                return $x;
                                        }
                                        else
                                        {
                                                show_404($this->fetch_directory().$segments[0]);
                                        }
                                }
                        }
                        else
                        {
                                // Is the method being specified in the route?
                                if (strpos($this->default_controller, '/') !== FALSE)
                                {
                                        $x = explode('/', $this->default_controller);
     
                                        $this->set_class($x[0]);
                                        $this->set_method($x[1]);
                                }
                                else
                                {
                                        $this->set_class($this->default_controller);
                                        $this->set_method('index');
                                }
     
                                // Does the default controller exist in the sub-folder?
                                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.'.php'))
                                {
                                        $this->directory = '';
                                        return array();
                                }
     
                        }
     
                        return $segments;
                }

 


                // If we've gotten this far it means that the URI does not correlate to a valid
                // controller class.  We will now see if there is an override
                if ( ! empty($this->routes['404_override']))
                {
                        $x = explode('/', $this->routes['404_override']);
     
                        $this->set_class($x[0]);
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');
     
                        return $x;
                }

 


                // Nothing else to do at this point but show a 404
                show_404($segments[0]);
        }
}
// END MY_Router Class

使用方法：把上面的代码另存为MY_Router.php,放在你应用目录的core目录下。假设你的应用放在application目录,哪么你把MY_Router.php文件放在application/core目录下即可：

原生的CI最多只支持一级目录,地址如下：controllers/directory/appname.php,现在你可以写成controllers/directory/directory/directory/appname.php,如果你不觉得累写多少都没关系 (^0^)。

现目前在Codeigniter 2.1.0、Codeigniter 2.1.1、Codeigniter 2.1.2都测试通过！