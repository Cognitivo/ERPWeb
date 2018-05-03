select contacts.name as contact,
round(sum(quantity)) as quantity
from sales_invoice as si
left join sales_invoice_detail as sd
on si.id_sales_invoice = sd.id_sales_invoice
left join contacts
on contacts.id_contact = si.id_contact
where si.trans_date between @StartDate and @EndDate
group by  contacts.id_contact;
