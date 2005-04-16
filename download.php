<?php

require_once("docutil.php");

$xml = $_GET["xml"];

if ($xml) {
    header('Content-type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
<versions>
";
} else {
    page_head("Download BOINC client software");
}

function xecho($x) {
    global $xml;
    if (!$xml) {
        echo $x;
    }
}

function dl_item($x, $y) {
    global $light_blue;
    echo "<tr><td valign=top  align=right width=30% bgcolor=$light_blue>$x</td>
        <td>$y</td></tr>
    ";
}

function version(
    $platform, $number, $desc, $filename, $date, $installer, $features=null, $issues=null
) {
    global $xml;
    $path = "dl/$filename";
    $url = "http://boinc.berkeley.edu/$path";
    $dlink = "<a href=$url>$filename</a>";
    $md = md5_file($path);
    $s = number_format(filesize($path)/1000000, 2);

    if ($xml) {
        $issues = htmlspecialchars($issues);
        echo "
<version>
    <platform>$platform</platform>
    <description>$desc</description>
    <date>$date</date>
    <version_num>$number</version_num>
    <url>$url</url>
    <filename>$filename</filename>
    <size_mb>$s</size_mb>
    <md5>$md</md5>
    <installer>$installer</installer>
    <features>$features</features>
    <issues>$issues</issues>
</version>
";
    } else {
        list_start();
        list_bar($desc);
        dl_item("File (click to download)", "$dlink ($s MB)");
        dl_item("Version number", $number);
        dl_item("Release date", $date);
        dl_item("Installer type", $installer);
        dl_item("MD5 checksum of download file", $md);
        if ($features) {
            dl_item ("New features", $features);
        }
        if ($issues) {
            dl_item ("Known issues", $issues);
        }
        list_end();
    }
}

function win_old() {
    global $xml;
    if ($xml) {
        return "Single-mode Windows installer";
    } else {
        return "<a href=client_windows.php>Single-mode Windows installer</a>";
    }
}

function win_new() {
    global $xml;
    if ($xml) {
        return "Windows installer";
    } else {
        return "<a href=win_install.php>Windows installer</a>";
    }
}

function bare_core() {
    global $xml;
    if ($xml) {
        return "Core client only (command-line)";
    } else {
        return "<a href=bare_core.php>Core client only (command-line)</a>";
    }
}

function sea() {
    global $xml;
    if ($xml) {
        return "Self-extracting archive";
    } else {
        return "<a href=sea.php>Self-extracting archive</a>";
    }
}

function mac_simple() {
    global $xml;
    if ($xml) {
        return "Menubar (simple GUI)";
    } else {
        return "<a href=menubar.php>Menubar (simple GUI)</a>";
    }
}

function mac_advanced() {
    global $xml;
    if ($xml) {
        return "Advanced GUI";
    } else {
        return "<a href=mac_advanced.php>Advanced GUI</a>";
    }
}

xecho( "
BOINC client software is available for
<ul>
<li> <a href=#windows>Windows</a>
<li> <a href=#mac>Mac OS X</a>
<li> <a href=#linux>Linux/x86</a>
<li> <a href=#solaris>SPARC/Solaris</a>
</ul>
<p>
Click on your computer type, or scroll down.
<p>
    If your computer is not of one of these types, you can
    <ul>
    <li> <a href=anonymous_platform.php>download the BOINC source code and compile it yourself</a> or
    <li> <a href=download_other.php>download executables from a third-party site</a>.
    </ul>
    <p>
    Download information is also available in
    <a href=download.php?xml=1>XML format</a>.
    <hr>

<a name=windows>
<h2>Microsoft Windows (all versions, Windows 95 and later)</h2>
");
version(
    "Windows",
    "4.25",
    "Recommended version",
    "boinc_4.25_windows_intelx86.exe",
    "3 Mar 2005",
    win_new(),
    "Works with HTTP proxies",
    "<ul>
    <li/> The BOINC screensaver conflicts with Microsoft Intellitype software.
    <li/>
    Applications that were built before October 2004 do not
    display screensaver graphics with the Service or Shared installation,
    or the Single-user installation with the password protect screensaver
    option on NT based machines.
    <li>
    If BOINC runs at the same time as Windows XP 3D screensavers,
    the system becomes sluggish and unresponsive.
    <li>
    Dial-up users should choose the single-user installation.
    <li>
    Graphics sometimes do not work with ATI Graphics card.
    If you have this problem,
    please visit
    <a href=http://setiweb.ssl.berkeley.edu/forum_thread.php?id=12948>the SETI@home Q&A area</a>,
    fill in the requested information, and click on the
    \"I also have this question\" button.
    </ul>
    If you experience any of these problems,
    we recommend using BOINC version 4.19.
    "
);
version(
    "Windows",
    "4.19",
    "Older version",
    "boinc_4.19_windows_intelx86.exe",
    "25 Jan 2005",
    win_old(),
    null,
    "<ul>
    <li> Doesn't work with some HTTP proxies (fixed in later versions).
    <li>
    If BOINC runs at the same time as Windows XP 3D screensavers,
    the system becomes sluggish and unresponsive.
    </ul>
    "
);
version(
    "Windows",
    "4.32",
    "Development version",
    "boinc_4.32_windows_intelx86.exe",
    "15 Apr 2005",
    win_new(),
    "<ul>
    <li>
    <a href=acct_mgt.php>Account Management via websites</a>
    <li>
    <a href=gui_rpc.php>Password protection for GUI RPC's</a>
    <li>
    This release should workaround the Intellisense/Intellipoint issue of
    closing down any application while Windows is in screensaver mode.
    <li>
    This release fixes a few issues with managed deployments with 
    Active Directory.
    <li>
    A new select computer dialog has been created that remembers
    which computers you have connected too.
    <li>
    A new statistics tab has been added to the BOINC manager, thanks to
    Jens Breitbart for the great feature.
    <li>
    Provide support for UMTS networks
    <li>
    Numerious usability fixes
    <li>
    Fixed a few connectivity problems on all platforms.
    </ul>
    ",
    "<ul>
    <li>
    Applications that were built before October 2004 do not
    display screensaver graphics
    with the Service or Shared install type,
    or the Single-user install type with the password protect screensaver
    option on NT based machines.
    <li>
    If BOINC runs at the same time as Windows XP 3D screensavers,
    the system becomes sluggish and unresponsive.
    <li>
    Same issues for dialup users as 4.25.
    <li>
    Same issues for ATI graphics cards as 4.25.
    </ul>
    "
);
xecho( "
<a name=mac>
<h2>Macintosh OS/X (10.2 and later)</h2>
");
version(
    "Mac",
    "4.19",
    "Recommended version",
    "boinc_4.19_powerpc-apple-darwin.gz",
    "25 Jan 2005",
    bare_core()
);
version(
    "Mac",
    "4.25 (v2)",
    "Development version (simple GUI)",
    "boinc_menubar_4.25_v2_mac.zip",
    "29 Mar 2005",
    mac_simple(),
    "<ul>
     <li>
     Adds support for HTTP and SOCKS proxies (see Known Issues below).
     <li>
     Adds support for  dual processor machines.
     <li>
     Fixes a bug which caused the menubar to disappear while leaving BOINC running in the background.
     <li>
     Fixes a bug which caused the application to freeze when choosing &quot;Stop&quot; or &quot;Quit BOINC Menubar&quot;.
     <li>
     Various other fixes and improvements.
    ",
    "<ul>
     <li>
     Proxies are still causing us problems. This feature may not be working properly yet.
    "
);
version(
    "Mac",
    "4.25",
    "Development version (command line)",
    "boinc_4.25_powerpc-apple-darwin.gz",
    "3 Mar 2005",
    bare_core()
);

xecho("
<a name=linux>
<h2>Linux/x86</h2>
");
version(
    "Linux/x86",
    "4.19",
    "Recommended version",
    "boinc_4.19_i686-pc-linux-gnu.gz",
    "25 Jan 2005",
    bare_core()
);
version(
    "Linux/x86",
    "4.32",
    "Development version",
    "boinc_4.32_i686-pc-linux-gnu.sh",
    "15 Apr 2005",
    sea()
);
xecho( "
<a name=solaris>
<h2>Solaris/SPARC</h2>
");
version(
    "Solaris/SPARC",
    "4.19",
    "Recommended version",
    "boinc_4.19_sparc-sun-solaris2.7.gz",
    "25 Jan 2005",
    bare_core()
);
version(
    "Solaris/SPARC",
    "4.32",
    "Development version",
    "boinc_4.32_sparc-sun-solaris2.7.sh",
    "15 Apr 2005",
    sea()
);

xecho("
    <h2>End-User License Agreement</h2>
    Versions 4.27 and earlier may contain an erroneous
    End-User Licence Agreement.
    The correct text is:
    <pre>
License Agreement

Please carefully read the following terms and conditions
before using this software.  Your use of this software indicates
your acceptance of this license agreement and warranty.

Disclaimer of Warranty

THIS SOFTWARE AND THE ACCOMPANYING FILES ARE DISTRIBUTED \"AS IS\"
AND WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY
OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
NO WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.

Restrictions

You may use this software on a computer system only if you own the system
or have the permission of the owner.

Distribution

This is free software.
It is distributed under the terms of the GNU Lesser General Public License
as published by the Free Software Foundation (http://www.fsf.org/).
The source code may be obtained
from the BOINC web site (http://boinc.berkeley.edu).

    </pre>
");
if ($xml) {
    echo "</versions>\n";
} else {
    page_tail();
}
?>
