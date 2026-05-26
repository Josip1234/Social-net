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