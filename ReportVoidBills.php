SELECT tblAppointments.AppointmentID, tblAppointments.offerid, tblAppointments.Status, tblInvoiceDetails.OfferAmt
FROM tblInvoiceDetails
left Join tblAppointments
on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblAppointments.offerid!='' and tblAppointments.Status='2'

select AppointmentID from tblAppointments where offerid!=''