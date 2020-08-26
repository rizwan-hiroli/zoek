SELECT top 10
	c.Id,
	c.IncId,
	c.Name,
	c.AddressLine1,
	c.AddressLine2,
	c.Area,
	c.Postcode,
	c.Balance,
	c.EstimatedDiscount,
	c.Balance + c.EstimatedDiscount AS TotalToPay,
	c.Nature,
	COUNT(DISTINCT tm.TeamMemberId) AS TeamMembers,
	COUNT(DISTINCT ad.Id) AS active_adverts,
	c.RegistrationDate,
	c.EstimatedDiscount,
	c.IsEnabled
	c.MonthlyClicks //this is added
	c.MonthlyApplications //this is added

FROM Companies c
	LEFT JOIN TeamMembers tm ON tm.CompanyId = c.Id
	LEFT JOIN BusinessUnits bu ON bu.CompanyId = c.Id
	LEFT JOIN AdvertData ad ON ad.BusinessUnitId = bu.Id AND ad.CurrentStatus = 2
	LEFT JOIN AdvertAdvancedSearchData aasd ON aasd.AdvertId = ad.AdvertId AND
aasd.ExpiryDate > GETDATE()

GROUP BY
	c.Id,
	c.IncId,
	c.Name,
	c.AddressLine1,
	c.AddressLine2,
	c.Area,
	c.Postcode,
	c.Nature,
	c.IsEnabled,
	c.RegistrationDate,
	c.Balance,
	c.EstimatedDiscount,
	c.IsEnabled
	c.MonthlyClicks //this is added
	c.MonthlyApplications //this is added


ORDER BY c.Name
