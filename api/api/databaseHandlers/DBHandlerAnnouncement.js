var mysql = require('mysql');
const config = require('../../config.js');
const express = require('express');
const router = express.Router();

var con = mysql.createConnection(config.dbConfig);

con.connect(function(err){
	if(err) throw err;
});


exports.getAnnouncements = function(cb){
	var sql = `SELECT announcement_id,
						announcement_title,
						announcement_text,
						date_format(announcement_date_schedule, '%m/%d/%Y %r') announcement_date_schedule, 
						announcement_link,
						admin
				FROM announcements`;
	con.query(sql, function(err,result){
		if(err){
			//console.log(err)
			cb({status: 'failed',error:err},null);
		}else{
			cb(null,result);
		}
	})
}

exports.addAnnouncement = function(announcement_title, announcement_text, announcement_link, admin, cb){
	var sql = `INSERT INTO announcements(announcement_title, announcement_text, announcement_link, admin)
		VALUES (?,?,?,?)`;
	con.query(sql, [announcement_title, announcement_text, announcement_link, admin], function(err,result){
		if(err){
			console.log(err)
			cb({status: 'failed',error:err},null);
		}else{
			cb(null,{status:'success'});
		}
	})
}

exports.getAnnouncementDetails = function(announcementId, cb){
	var sql = `SELECT * FROM announcements
		WHERE announcement_id = ?
		LIMIT 1`;
	con.query(sql, [announcementId], function (err, result) {
	  	if (err){
			cb({status: 'failed', error: err}, null);
		}else{
			cb(null,result);
		}
	});
};
