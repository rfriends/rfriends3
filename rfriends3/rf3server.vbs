Dim wss
Dim lnk

Set wss = WScript.CreateObject("WScript.Shell")
Set lnk = wss.CreateShortcut("rf3server.lnk")

lnk.TargetPath = wss.CurrentDirectory + "\rf3server.bat"
lnk.save
