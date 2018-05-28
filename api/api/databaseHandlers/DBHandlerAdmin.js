var mysql = require('mysql');
const config = require('../../config.js');
const express = require('express');
const router = express.Router();

var con = mysql.createConnection(config.dbConfig);

con.connect(function(err){
	if(err) throw err;
});


exports.getAdmins = function(cb){
	var sql = `SELECT admin_id,
						admin_email,
						admin_added_by
				FROM admins`;
	con.query(sql, function(err,result){
		if(err){
			//console.log(err)
			cb({status: 'failed',error:err},null);
		}else{
			cb(null,result);
		}
	})
}

exports.addAdmin = function(admin_email, admin_added_by, cb){
	var sql = `INSERT INTO admins(admin_email, admin_added_by)
		VALUES (?,?)`;
	con.query(sql, [admin_email, admin_added_by], function(err,result){
		if(err){
			console.log(err)
			cb({status: 'failed',error:err},null);
		}else{
			cb(null,{status:'success'});
		}
	})
}

exports.getAdminDetails = function(admin_id, cb){
	var sql = `SELECT * FROM admins
		WHERE admin_id = ?
		LIMIT 1`;
	con.query(sql, [admin_id], function (err, result) {
	  	if (err){
			cb({status: 'failed', error: err}, null);
		}else{
			cb(null,result);
		}
	});
};
