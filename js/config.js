requirejs.config({
	baseUrl: './js', //加载文件根路径
	urlArgs: 'v=' + new Date().getTime(), //下载文件是在url后面增加额外的query参数
	paths: { // 库框架指定路径
		'jquery': './lib/jquery-3.2.1.min',
		'bootstrap': './lib/bootstrap.min'
	},
	shim: { //不支持AMD的模块
      'bootstrap': [
        'jquery'
      ]
	},
	waitSeconds: 0,
	config: {
	}
})