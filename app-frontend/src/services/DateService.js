import { DateTime, Interval } from 'luxon';

export default {
  createDate: (date) => DateTime.fromSQL(date),
  getMinutesBetweenDates: (from, to) => {
    const interval = Interval.fromDateTimes(from, to);

    return interval.length('minutes');
  },
  isExpiredDate(expDateInterval){
    const expirationDate = DateTime.fromSeconds(expDateInterval); // Convert exp a DateTime
    const now = DateTime.now();
    return expirationDate < now;
  },
  getFirstAndLastDayOfMont : (year, month) => {
    const firstDay = DateTime.fromObject({ year, month, day: 1 }).toFormat('yyyy-LL-dd');
    const lastDay = DateTime.fromObject({ year, month }).endOf('month').toFormat('yyyy-LL-dd');
    return {
      firstDay,
      lastDay
    };
  },
  getMonths: () => {
    return [
      { "label": "Enero", "value": 1 },
      { "label": "Febrero", "value": 2 },
      { "label": "Marzo", "value": 3 },
      { "label": "Abril", "value": 4 },
      { "label": "Mayo", "value": 5 },
      { "label": "Junio", "value": 6 },
      { "label": "Julio", "value": 7 },
      { "label": "Agosto", "value": 8 },
      { "label": "Septiembre", "value": 9 },
      { "label": "Octubre", "value": 10 },
      { "label": "Noviembre", "value": 11 },
      { "label": "Diciembre", "value": 12 }
    ];
  },
};
