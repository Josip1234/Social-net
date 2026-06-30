 select p.userId,p.firstName,p.lastName,p.email,p.sex,p.dateOfBirth,i.imageName,i.url,i.profileMarkImage,pd.acTypeId,aty.acTypeName,pd.accountStatus,pd.registrationDate
              ,ad.street,cit.postNumber,cit.name as CitName,st.name as StName from profile p right join image i on p.userId=i.userId
              right join profiledetails pd on p.userId=pd.proDetId 
              right join address ad on p.addressId=ad.addressId
              right join city cit on ad.postNumber=cit.postNumber
              right join state st on cit.stateId=st.stateId
              right join accounttype aty on 
              pd.acTypeId = aty.acTypeId
              where p.userId=2;
              
select * from profiledetails;
select proDetId from profiledetails where userId=2;

select LAST_DAY('2020-12-01');
select day(LAST_DAY('2020-12-01'));

SELECT DAYOFYEAR(
    LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH))
) AS NumberOfDaysInCurrentYear;

SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/
(SELECT DAYOFYEAR(
    LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH))
)
),0) as Age FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId;

select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId;

select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId order by lc.idLogCon asc;

select count(lc.idLogCon) as total from logger_content lc;

select count(lc.idLogCon) as total from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId
where at.acTypeName like "%Admin%";

select act.acTypeName as dataTypeRec from accounttype act;

select lc.idLogCon,lc.loggerDescription,lc.userAdded,lc.userUpdated,lc.userDeleted,lc.dateDeleted,lc.dateUpdated,lc.dateAdded,at.acTypeName from logger_content lc inner join database_logger dl on lc.dbLogId=dl.dbLogId
inner join databaseuser du on dl.userId=du.userId inner join accounttype at on du.acTypeId=at.acTypeId where at.acTypeName like '%Admin%' order by lc.idLogCon asc LIMIT 5 OFFSET 5;

SELECT p.userId,concat(p.firstName," ",p.lastName) as user, p.email, p.dateOfBirth,pd.accountStatus, at.acTypeName 
, du.userName as databaseUser FROM profile p
inner join profiledetails pd on pd.userId=p.userId inner join accounttype at on pd.acTypeId=at.acTypeId
inner join databaseuser du on at.acTypeId=du.acTypeId where p.userId != 2;