<?php
require_once("docutil.php");
page_head("Core client: main loop logic");
echo "
<p>
The main loop of the core client repeatedly calls the following function:
<pre>
bool CLIENT_STATE::do_something() {
    bool action=false;
    
    if (check_suspend_activities()) return false;
    action |= net_xfers->poll();
    action |= http_ops->poll();
    action |= file_xfers->poll();
    action |= active_tasks->poll();
    action |= scheduler_rpcs->poll();
    action |= start_apps();
    action |= pers_xfers->poll();
    action |= handle_running_apps();
    action |= handle_pers_file_xfers();
    action |= garbage_collect();
    write_state_file_if_needed();
    return action;
}
</pre>

<p>
This function initiates new activities as needed,
and checks for the completion of current activities.
It is to be called periodically from either a sleep loop
(command-line program) or timer handler of event loop (GUI program).
It returns true if any change occurred,
in which case it should be called again without sleeping.

<p>
The various functions called are as follows:

<p>
<b>check_suspend_activities</b> checks for conditions such as
recent mouse/keyboard input, or running on batteries,
in which user preferences dictate that no work be done.
<p>
<b>net_xfers->poll(), http_ops->poll(), file_xfers->poll()
and pers_xfers->poll()</b>
manage the internal transitions of the various FSM layers.
<p>
<b>start_apps()</b> checks whether it's possible to start an
application, i.e. a CPU slot is vacant
and there's a result with all its input files present.
If so it starts the application.
<p>
<b>handle_running_apps()</b> checks whether a running application
has exited, and if so cleans up after it.
<p>
<b>handle_pers_file_xfers()</b>
starts new file transfers as needed.
<p>
<b>garbage_collect()</b>
checks for objects that can be discarded.
For example, if a file is non-sticky and is no longer
referenced by any work units or results, both the FILE_INFO
and the underlying file can be deleted.
If a result has been completed and acknowledged,
the RESULT object can be deleted.
<p>
<b>write_state_file_if_needed()</b>:
any of the above functions that changes state in a way that
should be written to client_state.xml
(e.g. that needs to survive this execution of the core client)
sets a flag <b>client_state_dirty</b>.
write_state_file_if_needed() writes client_state.xml if
this flag is set.
";
page_tail();
?>
