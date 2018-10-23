<table class="debugger_outertable">
 <tr><td> <div class="debuginfo">Debug Info</div></td></tr>
  <tr>
    <td>
        <div id="container" class="debugger_container">
          <div id="debugger">
            <ul>
              <li class="active"><a href="tab-1" >SQL</a></li>
              <li><a href="tab-2">LOGS</a></li>
              <li><a href="tab-3">REQUEST</a></li>
              <li><a href="tab-4">GLOBALS</a></li>
              <li><a href="tab-5">SESSION</a></li>
              <li><a href="tab-6">CONSTANTS</a></li>
             </ul>
              <div id="tab-1">
                <pre>
                    <table class="debug_table">
                        <?php
                            if(sizeof(PageContext::$debugObj->sqls) > 0)
                            {
                                    foreach(PageContext::$debugObj->sqls as $sql)
                                    {

                                            echo "<tr>
                                            <td>";
                                                             echo $sql->query. " <br />(<b>".round($sql->timetaken,4)."</b> ms)";
                                            echo "</td>
                                             </tr> ";
                                    }
                            }
                            ?>
                    </table>
                </pre>
            </div>

             <div id="tab-2">
                 <pre>
                        <table class="debug_table">
                            <?php
                                if(sizeof(PageContext::$loggerObj->log) > 0)
                                {
                                        foreach(PageContext::$loggerObj->log as $log)
                                        {

                                                echo "<tr><td>";
                                            echo $log->trace['file']." : ".$log->trace['line']." -> <br />";
                                            print_r($log->data);
                                                echo  "</td></tr> ";
                                            echo "<tr><td class='log_divider'></td></tr>"    ;
                                        }
                                }
                                ?>
                        </table>
                 </pre>
            </div>
            <div id="tab-3">
                <pre>
                      <table class="debug_table">
                <?php
                        foreach(PageContext::$debugObj->request as $key => $value){
                                echo "<tr><td class='debug_table_key'>".$key. "</td><td class='debug_table_val'>".$value. "</td></tr>";
                        }
                  ?>
                     </table>
                </pre>
            </div>
            <div id="tab-4">
                 <pre>
                    <table class="debug_table">
                  <?php
                        foreach(PageContext::$debugObj->globals as $key => $value){
                                echo "<tr><td class='debug_table_key'>".$key. "</td><td debug_table_val> ".$value. "</td></tr>";
                        }
                  ?>
                    </table>
                 </pre>
            </div>


            <div id="tab-5">
                 <pre>
                      <table class="debug_table">
                      <?php
                       $_SESSION['debug']=1;
                            foreach($_SESSION as $key => $value){
                                    if(is_array($value)){
                                    echo "<tr><td class='debug_table_key'>".$key. "</td><td class='debug_table_val'><table> ";
                                     foreach($value as $k => $val){
                                       echo "<tr><td class='debug_table_key'>".$k. "</td><td class='debug_table_val'> ".
                                      $val.
                                      "</td></tr>";
                                     }
                                     echo "</table></td></tr>";

                                    }
                                    else
                                    {
                                    echo "<tr><td class='debug_table_key'>".$key. "</td><td class='debug_table_val'> ".
                                      $value.
                                      "</td></tr>";
                                    }
                            }
                      ?>
                      </table>
                 </pre>

            </div>

            <div id="tab-6">
               <pre>
                    <table class="debug_table">
                <?php
                    $debug_constants = get_defined_constants(true);
                    foreach($debug_constants['user'] as $key => $value){
                                    echo "<tr><td class='debug_table_key'>".$key. "</td><td class='debug_table_val'> ".$value. "</td></tr>";
                            }
                ?>
                  </table>
              </pre>
            </div>

          </div>
        </div>
    </td>
  </tr>
</table>



 