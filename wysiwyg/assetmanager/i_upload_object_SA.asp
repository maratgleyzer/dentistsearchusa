<%
dim sUploadedFile
sUploadedFile=""

if Request.QueryString("upload")="Y" then

	set oFSO = server.CreateObject("SoftArtisans.FileManager")
	Set oUpload = Server.CreateObject("SoftArtisans.FileUp")
	
	ffilter=oUpload.form("ffilter")'ffilter

	'UPLOAD PROCESS HERE
	if(Len(CStr(oUpload.form("inpCurrFolder2")))=0) then
		currFolder = server.MapPath(arrBaseFolder(0)) 'opened folder (Physical)
	else		
		currFolder = oUpload.form("inpCurrFolder2") 'opened folder (Physical)
	end if
	
	'UPLOAD PROCESS HERE
	oUpload.MaxBytes = 9000000
	oUpload.Path = currFolder
	oUpload.Save
	if (err.number<>0) then sMsg = err.Description
	Set oUpload = Nothing
	
	set oFSO = server.CreateObject ("Scripting.FileSystemObject")
else
	set oFSO = server.CreateObject ("Scripting.FileSystemObject")
	
	ffilter=request("ffilter")'ffilter
	
	if(Len(CStr(request("inpCurrFolder")))=0) then
		currFolder = server.MapPath(arrBaseFolder(0)) 'opened folder (Physical)
	else
		currFolder = request("inpCurrFolder") 'opened folder (Physical)
	end if

	if(Len(CStr(request("inpFileToDelete")))<>0) then 'Delete File
		Set oFile = oFSO.GetFile(Server.MapPath(CStr(request("inpFileToDelete"))))
		oFile.Delete
	end if
	sMsg = ""
End If
%>
