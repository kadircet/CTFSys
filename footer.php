		<div id="footer">
			<div class="container">
				<p class="text-muted">
					<a href="http://0xdeffbeef.com/" target="_blank">
						<img src="http://s24.postimg.org/qhr53w0qt/33o_HPYh_W.png" height="80px" title="0xdeffbeef" />
					</a>
					<a href="http://ieee.metu.edu.tr/" target="_blank">
						<img src="http://www.ieee.metu.edu.tr/tr/wp-content/uploads/2013/09/logoo.png" height="80px" title="IEEE " />
					</a>
				</p>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="/jsencrypt.js"></script>
		<script>
			var pubKey = "-----BEGIN PUBLIC KEY-----\n"+
				"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsPVJhipcG/d8CjYqb/0r\n"+
				"2plK0/Xz78gX1VwqU8YjrkdmqS2NIbdInablfKIvEzQBGC9Y7hQWqpSeJqx1S8cJ\n"+
				"Sxob+tbpioh6n9UMwTkAu2cFXqchLZCQl1r0qVHfiSz3FsqteuPqucOWXPS/FnTw\n"+
				"zsuNVDBYHVUHQB2XjhQqlU6tlwZJYGDoe+qfCT+Pn3RW5S0g+iPij8zuujSwgm/t\n"+
				"Ou+F1m86CcHWS/hdYAkqmcq9Oywr3XgwCcp1R0Bzd2lcxj4RCOj13p16sGES1msq\n"+
				"qVi60iVbVVDCMYFwk+7bXTMck5gIiHNDLPF3+cD+l17Y9ljpke/KnZLtDlQd7CVX\n"+
				"dwIDAQAB\n"+
				"-----END PUBLIC KEY-----";
			var enc = new JSEncrypt;
			enc.setPublicKey(pubKey);
	
	
			var encForm = function(e)
				{
					var data = {};
					for(var i=0;i<e.target.length;i++)
					{
						if(e.target[i].name!="desc" && e.target[i].value.length<240)
							data[e.target[i].name] = enc.encrypt(e.target[i].value);
						else
							data[e.target[i].name] = btoa(e.target[i].value);
					}
					
					var form = '';
					$.each( data, function( key, value ) {
						form += '<input type="hidden" name="'+key+'" value="'+value+'">';
					});
					form = '<form action="' + e.target.attributes['action'].value + '" method="POST">' + form + '</form>';
					console.log(form);
					$(form).appendTo('body').submit();
					
					e.preventDefault();
					return false;
				};
				
			$("form").submit(encForm);
			
			function setLocale(lang)
			{
				var form = $('<form action="#" method="post">' +
				  '<input type="hidden" name="locale" value="' + lang + '" />' +
				  '<input type="hidden" name="action" value="locale" />' +
				  '</form>');
				$(form).submit(encForm);
				$(form).appendTo('body').submit();
			}
			
			function logout()
			{
				var form = $('<form action="#" method="post">' +
				  '<input type="hidden" name="action" value="logout" />' +
				  '</form>');
				$(form).submit(encForm);
				$(form).appendTo('body').submit();
			}
		</script>
	</body>
</html>
