 select p.userId,p.firstName,p.lastName,p.email,p.sex,p.dateOfBirth,i.imageName,i.url,i.profileMarkImage,pd.acTypeId,aty.acTypeName,pd.accountStatus,pd.registrationDate
              ,ad.street,cit.postNumber,cit.name as CitName,st.name as StName from profile p right join image i on p.userId=i.userId
              right join profiledetails pd on p.userId=pd.proDetId 
              right join address ad on p.addressId=ad.addressId
              right join city cit on ad.postNumber=cit.postNumber
              right join state st on cit.stateId=st.stateId
              right join accounttype aty on 
              pd.acTypeId = aty.acTypeId
              where p.userId=2;